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
            case 'home': home(); break;

            case 'login': login(); break;
			
			case 'signup' : signup(); break;

            case 'signupDb' : signupDb(); break;

            case 'signin': signin(); break;
			
			case 'getFlight' : getflight(); break;

            case 'logout': logout(); break;

            case 'settings': settingsView(); break;

            case 'chgPwd': chgPwd(); break;

            default: throw new Exception("Action non valide");
        }
    }
    else
        home();
}
catch (Exception $e)
{
    //erreur($e->getMessage());
}