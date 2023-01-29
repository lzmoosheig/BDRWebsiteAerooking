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


function signup()
{
	require "views/view_signup.php";
}

function sliderTest()
{
    require "views/view_testSlider.php";
}

function myaccount()
{
    $allRes = getReservation();


    require "views/view_myaccount.php";
}

function resDetails()
{
    $resDetail = getPassengerFromRes();
    $moreDetail = getMultipleFlight();

    require "views/view_resDetails.php";
}

function showFlight()
{
    $allflight = getallFlight($_POST);
    require "views/view_showflight.php";
}

function viewAdmin()
{

    $allFlight = getAllFlightAdmin();

    if(isset($_SESSION['user']) && $_SESSION['user'] == "admin@aeroking.com")
    {
        require "views/view_admin.php";
    } else {
        require "views/view_flight.php";
    }

}

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

function viewAddFlight()
{
    $airports = getAirportName();
    $companies = getAllCompanies();

    require "views/view_AddFlight.php";
}

function createnewflight()
{
    createFlight($_POST);

    require "views/view_addFlightSuccess.php";
}

/**
 * login: Show Login Page
 */
function login()
{
    require "views/view_login.php";
}

function signupDb()
{
    extract($_POST);
    // $email & $pswd
    // Query à la DB pour insert le password et le mail
    // INSERT INTO compte (mail,motdepasse) VALUES ($email,$pswd);


}

/**
 * Sign In: The user will use this function sign in into the website
 */
function signin()
{
    extract($_POST);

    // $email & $pswd

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

function reserveFlight()
{

    makeReservation($_SESSION['post-data'], $_POST);

    require "views/view_res.php";
}
function reserverVol()
{
    require "views/view_reservation.php";
}

/**
 * Logout: the user will use this function sign out the website
 */
function logout()
{
    if(isset($_SESSION['user']))
    {
        session_destroy();
    }

    header("location:index.php?action=getFlight");
}
