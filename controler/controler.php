<?php
/**
 * Created by PhpStorm.
 * User: Android
 * Date: 02.05.2018
 * Time: 21:13
 */

require "model/model.php";



stream_context_set_default([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ]
    ]);


/**
 * myaccount: This function is used to access to all reservation for the user
 * @return void
 */
function myaccount()
{
    $allRes = getReservation();
    require "views/view_myaccount.php";
}

/**
 * resDetails: This function is used to get flight details such as passengers list
 * @return void
 */
function resDetails()
{
    $resDetail = getPassengerFromRes();
    $moreDetail = getMultipleFlight();
    require "views/view_resDetails.php";
}

/**
 * signupView: This function is used to access to the signup view
 * @return void
 */
function signupView()
{
    if(!isset($_SESSION['user']))
    {
        require "views/view_signup.php";
    } else {
        require "views/view_flight.php";
    }
}

/**
 * showFlight: This function is used to show flight according to user filters
 * @return void
 */
function showFlight()
{
    $allflight = getallFlight($_POST);
    require "views/view_showflight.php";
}

/**
 * viewAdmin: This function is used to access the admin panel
 * @return void
 */
function viewAdmin()
{
    if(isset($_SESSION['user']) && $_SESSION['user'] == "admin@aeroking.com")
    {
        require "views/view_admin.php";
    } else {
        require "views/view_flight.php";
    }

}

/**
 * viewAllFlights: This function is used to access the all flight view (Only for admin)
 * @return void
 */
function viewAllFlights()
{
    $allFlight = getAllFlightAdmin();
    require "views/view_allFlight.php";
}

/**
 * getflight: This function is used to access the flight search form
 * @return void
 */
function getflight()
{
    $airports = getAirportName();
    $companies = getAllCompanies();
    $classes = getClasses();

    if (!$airports || !$companies || !$classes) {
        echo "Une erreur s'est produite.\n";
        exit;
    }
	require "views/view_flight.php";
}

/**
 * viewAddFlight: This function is used to access the view where you can add flight
 * @return void
 */
function viewAddFlight()
{
    $airports = getAirportName();
    $companies = getAllCompanies();

    require "views/view_AddFlight.php";
}

/**
 * createnewflight: This function is used to create new flight
 * @return void
 */
function createnewflight()
{
    createFlight($_POST);

    require "views/view_addFlightSuccess.php";
}

/**
 * login: This function is used to show Login Page
 * @return void
 */
function login()
{
    require "views/view_login.php";
}

/**
 * signupDb: This function is used to register new account to the database
 * @return void
 */
function signupDb()
{
    signUP($_POST);
    extract($_POST);

    $_SESSION['user'] = $email;
    header("location:index.php?action=getFlight");
}

/**
 * Sign In: This function is used to sign in into the website
 * @return void
 */
function signin()
{
    extract($_POST);

    if (isset($email) && isset($pswd))
    {
        // Check if user exist in DB
        if(compareMail($email))
        {
            // Get user information from DB
            $userinformation = getUser($email);

            if(empty($userinformation))
            {
                header("location:index.php?action=login&errLogin=true");
            }

            while ($row = pg_fetch_row($userinformation)) {

                if($pswd == $row[1] && $email == $row[0])
                {
                    // Store user information in Session
                    $_SESSION['user'] = $row[0];
                    header("location:index.php?action=getFlight");
                } else {
                    header("location:index.php?action=login&errLogin=true&qMail=$mail");
                }
            }
        }
    }
}

/**
 * reserveFlight: This function is used to reserve flight
 * @return void
 */
function reserveFlight()
{
    if(isset($_SESSION['user'])) {
        makeReservation($_SESSION['post-data'], $_POST);

        require "views/view_res.php";
    } else {
        require "views/view_getFlight.php";
    }
}

/**
 * reserverVol: This function is used to access the reservation form (to fill passengers infos)
 * @return void
 */
function reserverVol()
{
    if(isset($_SESSION['user'])) {
        require "views/view_reservation.php";
    } else {
        require "views/view_flight.php";
    }
}

/**
 * Logout: This function is used to sign out of the website
 * @return void
 */
function logout()
{
    if(isset($_SESSION['user']))
    {
        session_destroy();
    }

    header("location:index.php?action=getFlight");
}

/**
 * supprimerVol: This function will be used to delete a flight (Only for admin)
 * @return void
 */
function supprimerVol()
{
    if(isset($_SESSION['user']) && $_SESSION['user'] == "admin@aeroking.com")
    {
        deleteFlight();

        header("location:index.php?action=viewAdmin&volSupprime=success");
    } else {
        header("location:index.php?action=flight");
    }
}
