<?php
session_start();
/**
 * User: Leo.ZMOOS
 * Index.php : page de triage des actions reçues dans l'URL
 */

require "controler/controler.php";

try
{
    if (isset($_GET['action']))
    {
        $action = $_GET['action'];
        // Sélection de l'action passée par l'URL
        switch ($action)
        {
            case 'login': login(); break;
			
			case 'signup' : signup(); break;

            case 'signupDb' : signupDb(); break;

            case 'signin': signin(); break;

            case 'showFlight': showFlight(); break;

            case 'reserverVol': reserverVol(); break;

            case 'viewAdmin': viewAdmin(); break;

            case 'viewAddFlight': viewAddFlight(); break;

            case 'myaccount': myaccount(); break;

            case 'resDetails': resDetails(); break;

            case 'createPassengers': createPassengers(); break;

            case 'createnewflight': createnewflight(); break;

            case 'reserveFlight' : reserveFlight(); break;

            case 'sliderTest': sliderTest(); break;
			
			case 'getFlight' : getflight(); break;

            case 'logout': logout(); break;

            default: throw new Exception("Action non valide");
        }
    }
    else
        getflight();
}
catch (Exception $e)
{
    //erreur($e->getMessage());
}