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
 * home: Show Home page
 */
function home()
{
    require "views/view_home.php";
}

/**
 * aboutus: Show About Us page
 */
function aboutus()
{
    require "views/view_aboutus.php";
}


function signup()
{
	require "views/view_signup.php";
}

/**
 * login: Show Login Page
 */
function login()
{
    if(!isset($_SESSION['user']))
    {
        require "views/view_login.php";

    } else {

        require "views/view_home.php";
    }
}

/**
 * fillCPA_View: Show Fill Cpa Page
 */
function fillCPA_View()
{
    if(isset($_SESSION['user']))
    {
        $AllShelterName = getAllSheltersName();

        $result = $AllShelterName->fetchAll(PDO::FETCH_ASSOC);

        require "views/view_fillcpa.php";

    } else {

        require "views/view_home.php";
    }
}

/**
 * Sign In: The user will use this function sign in into the website
 */
function signin()
{
    extract($_POST);
    // $username & $pass

    if (isset($username) && isset($pass))
    {
        // Check if user exist in DB
        if(compareMail($username))
        {
            // Hash Password (SHA-512)
            $hashedpass = hash('sha512', $pass);


            // Get user information from DB
            $userinformation = getUser($username);


            $result = $userinformation->fetch(PDO::FETCH_ASSOC);
        }
        if(empty($result))
        {
            header("location:index.php?action=login&errLogin=true");
        }
        elseif($hashedpass == $result['Password'] && $username == $result['MailAddress']){

            // Store user information in Session
            $_SESSION['user'] = $result;
            header("location:index.php?action=home");
        }
        else
        {
            header("location:index.php?action=login&errLogin=true&qMail=$username");
        }
    }
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

    header("location:index.php?action=home");
}

/**
 * fillCPADatas: This function will be used to fill the table "CPA" with CPA report data
 */
function fillCPADatas()
{
    extract($_POST);

    // Protection against XSS/Injected SQL attack
    $message = str_replace('<', ' ', $message);
    $message = str_replace('>', ' ', $message);
    $message = str_replace("'", ' ', $message);

    $maxratechoice = 5;

    $pattern = '/^[a-zA-Z\s]+$/';
    // Verify every data entries to validate format and avoid wrong values
    if (sizeof($_POST)==13)
    {
        if ($Pipe == 0 || 1 && $Fuses  == 0 || 1 && $GazFilter  == 0 || 1 && $Guideline == 0 || 1 && $Handwheel  == 0 || 1 && $SelfReleasing  == 0 || 1 && $Threshold == 0 || 1)
        {
            // preg_match($pattern, $ManagerName) need to test thisß
                if ($HallState >=1 && $HallState <= $maxratechoice && $KitchenState >=1 && $KitchenState<= $maxratechoice && $DoorsState >=1 && $DoorsState <= $maxratechoice && $LightsState >=1 && $LightsState <=$maxratechoice)
                {
                    // Fill "CPA" table in DB
                    addCPAReport($_POST);

                    // Get ID Shelter to get all name rooms by shelterß
                    $idShelter = GetShelterID($ShelterName);
                    $idShelter = $idShelter->fetch(PDO::FETCH_ASSOC);

                    $getNameRooms = getNameRooms($idShelter["idShelters"]);

                    $resultats = $getNameRooms->fetchAll(PDO::FETCH_ASSOC);

                    $_SESSION['NameRooms'] = array();

                    foreach ($resultats as $nameroom)
                    {
                        array_push($_SESSION['NameRooms'],$nameroom["Name"]);

                    }

                    require "views/view_fillcpaRooms.php";
                }
            }
        }
}


/**
 * settingsView: Show settings page
 */
function settingsView()
{
    require "views/view_settings.php";
}

/**
 * chgPwd_View: Show Change Password Page
 */
function chgPwd_View()
{
    require "views/view_chgpwd.php";
}

/**
 * chgPwd: This function will be used to change the user's password
 */
function chgPwd()
{
    extract($_POST);

    $oldpwd = hash('sha512', $oldpwd);
    $newpwd = hash('sha512', $newpwd);
    $newpwdconf = hash('sha512', $newpwdconf);


    $mail = $_SESSION['user']['MailAddress'];


    if (isset($_SESSION['user']['MailAddress'],$_SESSION['user']['Password']))
    {
        if (isset($oldpwd,$newpwd,$newpwdconf))
        {
            if($newpwd == $newpwdconf)
            {
                if(comparePassword($oldpwd, $mail))
                {
                    changePwd($newpwd,$mail);
                    header("location:index.php?action=chgPwd_View_Success");
                }else{
                    header("location:index.php?action=chgPwd_View&oldPassError");
                }

            }else{
                header("location:index.php?action=chgPwd_View&confError");
            }
        }
    }
}

/**
 * chgPwd_View_Success: Show Change Password Validation Page
 */
function chgPwd_View_Success()
{
    require "views/view_chgpwdsuccess.php";
}

/**
 * crtML_View: Show Create Mailing List Page
 */
function crtML_View()
{
    require "views/view_crtml.php";
}

/**
 * shwML_View: Show All user's mailing list
 */
function shwML_View()
{
    require "views/view_shwml.php";
}

/**
 * createshelter_View
 */
function createshelter_View()
{
    if (isset($_SESSION['nbRooms']))
    {
        unset($_SESSION['nbRooms']);
    }

    require "views/view_createshelter.php";
}

/**
 * newshelter: This function will be use to create a new shelter and fill "Shelters" table in DB
 */
function newshelter()
{
    // Protection against XSS/Injected SQL attack
    $message = str_replace('<', ' ', $message);
    $message = str_replace('>', ' ', $message);
    $message = str_replace("'", ' ', $message);
    $message = str_replace("-", ' ', $message);
    $_POST['message'] = $message;

    extract($_POST);

    // Stock sheltername & nbRooms temporary in Session

    if(!isset($_SESSION['sheltername']))
    {
        $_SESSION['sheltername'] = $sheltername;
    }

    if(!isset($_SESSION['nbRooms']))
    {
        $_SESSION['nbRooms'] = $nbRooms;
    }

    $result = verifyShelterName($sheltername);
    $verify = $result->fetch(PDO::FETCH_ASSOC);

    // Verify Shelter Name
    if($verify)
    {
        header("location:index.php?action=createshelter&error=shelternameexisting");
    }
    else
    {
        // Create new shelter in DB
        createNewShelter($_POST);
        require "views/view_createshelterrooms.php";
    }
}

/**
 * newSheltertoDB: This function be used to fill the table "Rooms" for new Shelter
 */
function newSheltertoDB()
{
    if(isset($_SESSION['sheltername'],$_SESSION['nbRooms']))
    {
        $result = getShelterID($_SESSION['sheltername']);
        $idShelter = $result ->fetch(PDO::FETCH_ASSOC);

        $temp = array();

        for ($i=0;$i<$_SESSION['nbRooms'];$i++)
        {
            array_push($temp,$_POST["Room".$i]);

            // Keep unique values
            if (count(array_unique($temp))<count($temp))
            {
                header("location:index.php?action=newshelter&error=roomsnameexisting");
            }
            else
            {
                fillNewRoomState($_POST["Lights".$i],$_POST["Doors".$i],$_POST["Room".$i], $idShelter["idShelters"]);
            }
        }

        require "views/view_newsheltervalidation.php";
    }
    else {require "views/view_createshelter.php";}
}

/**
 * createML: This function will be used to create a mail list
 */
function createML()
{
    extract($_POST);

    // verify if field have been filled
    if (strlen($datas) && strlen($name) > 0)
    {
        // Verify existing mailing list
        $result = verifyMailingList($_POST["name"]);
        $verifyExistingMail = $result->fetch(PDO::FETCH_ASSOC);

        // Redirecting user if mail name is already taken
        if($verifyExistingMail)
        {
            header("location:index.php?action=crtML_View&error=mailexisting");
        }
        else
        {
            // Fill MailingList table
            addMailingList($_POST["name"]);

            // Get Mailing List ID
            $result = GetMailingListID($_POST["name"]);
            $mailingListID = $result->fetch(PDO::FETCH_ASSOC);

            // Parse $datas that contains all mails separated by ','
            $delimiter = ',';
            // Keep only unique datas in array
            $result = array_unique(explode($delimiter,$datas));

            // Fill recipient table
            foreach ($result as $recipient)
            {
                $result = verifyRecipient($recipient);
                $verifyExistingMail = $result->fetch(PDO::FETCH_ASSOC);

                if ($verifyExistingMail)
                {
                    $result = GetRecipientID($recipient);
                    $recipientID = $result->fetch(PDO::FETCH_ASSOC);

                    // Fill Intermediate Table Recipient has MailingList
                    fillRecipientMailingList($recipientID["idRecipients"],$mailingListID["idMailingList"]);
                }
                else
                {
                    addRecipient($recipient);
                    $result = GetRecipientID($recipient);
                    $recipientID = $result->fetch(PDO::FETCH_ASSOC);
                    // Fill Intermediate Table Recipient has MailingList
                    fillRecipientMailingList($recipientID ["idRecipients"],$mailingListID["idMailingList"]);
                }
            }
            require "views/view_createMLValidation.php";
        }
    }
}

/**
 * Statisticals_View: Show Statisticals Page
 */
function Statisticals_View()
{
    $result = getAllSheltersName();

    $AllShelterName = $result->fetchAll(PDO::FETCH_ASSOC);

    // Get all Shelters State
    $result = getAllSheltersState();
    $resultats = $result->fetchAll(PDO::FETCH_ASSOC);

    // Create multiple state variable
    $vgoodStateArrayCount = 0;
    $goodStateArrayCount = 0;
    $averageStateArrayCount = 0;
    $badStateArrayCount = 0;
    $vbadStateArrayCount = 0;


    // Do average formula to know the general state of one shelter
    foreach ($resultats as $element)
    {
        $temp = array();
        foreach ($element as $key=>$value)
        {
           array_push($temp,$value);
        }
        $average = ceil( array_sum($temp) / count($temp));

        switch ($average)
        {
            case 1: $vbadStateArrayCount++; break;

            case 2: $badStateArrayCount++; break;

            case 3: $averageStateArrayCount++; break;

            case 4: $goodStateArrayCount++; break;

            case 5: $vgoodStateArrayCount++; break;
        }
    }

    require "views/view_statisticals.php";
}

/**
 * roomsState: This function will be used to fill the "Rooms" table
 */
function roomsState()
{
    extract($_POST);

    foreach ($_SESSION['NameRooms'] as $element)
    {
        $array = array();
        foreach ($_POST as $key => $value)
        {
            if (strpos($key,$element))
            {
                array_push($array,$value);
            }
        }
        fillRoomsState($array[0],$array[1],$element);
    }

    require "views/view_fillcpavalidation.php";
}

/**
 * sendmail_View: Show the send mail page
 */
function sendmail_View()
{
    $results = getCPAbyUser($_SESSION['user']['MailAddress']);
    $CPAReport = $results->fetchAll(PDO::FETCH_ASSOC);


    $datasShelters = array();
    $datasCPA = array();

    foreach ($CPAReport as $element => $element_value)
    {
        $string = "";
        array_push($datasShelters,$element_value["Sheltersname"]);

        foreach ($element_value as $value)
        {
            $string .= $value." | ";
        }
        array_push($datasCPA,$string);
    }

    $datasML = array();

    $results = getMailingListbyUser($_SESSION['user']['MailAddress']);
    $MailingList = $results->fetchAll(PDO::FETCH_ASSOC);

    foreach ($MailingList as $element => $element_value)
    {
        foreach ($element_value as $value)
        {
            array_push($datasML,$value);
        }
    }

    require "views/view_sendmail.php";
}

/**
 * @throws Html2PdfException
 * SendCPAMail: This function will be used to generate a PDF of the CPA report and send it by mail to the selected Mail List
 */

function sendCPAmail()
{

    // Get Recipients list
    $results = getRecipients($_POST['MailList']);
    $Recipients = $results->fetchAll(PDO::FETCH_ASSOC);

    // Get user information
    $results = getUserInfo($_SESSION['user']['MailAddress']);
    $UserInfos = $results->fetchAll(PDO::FETCH_ASSOC);

    $results = getCPAData($_POST['CPA']);
    $CPAData = $results->fetchAll(PDO::FETCH_ASSOC);

    foreach ($CPAData as $element => $element_value)
    {
        foreach ($element_value as $element => $element_value)
        {

            if(strlen($element_value) == 1 && $element_value == 0)
            {
                $CPAData[0][$element] = "Non";
            }
            elseif(strlen($element_value) == 1 && $element_value == 1) $CPAData[0][$element] = "Oui";
        }
    }

    $stringUserInfo = $UserInfos[0]["Lastname"]." ".$UserInfos[0]["Firstname"];


    // PDF Content
    $content = '<style type="text/css">
                    <!--
                    span.cls_008{font-family:Arial,serif;font-size:11.8px;color:rgb(0,0,0);font-weight:bold;font-style:italic;text-decoration: underline}
                    div.cls_008{font-family:Arial,serif;font-size:11.8px;color:rgb(0,0,0);font-weight:bold;font-style:italic;text-decoration: none}
                    span.cls_002{font-family:Arial,serif;font-size:11.8px;color:rgb(0,0,0);font-weight:bold;font-style:italic;text-decoration: none}
                    div.cls_002{font-family:Arial,serif;font-size:11.8px;color:rgb(0,0,0);font-weight:bold;font-style:italic;text-decoration: none}
                    span.cls_009{font-family:Arial,serif;font-size:10.8px;color:rgb(0,0,0);font-weight:bold;font-style:italic;text-decoration: underline}
                    div.cls_009{font-family:Arial,serif;font-size:10.8px;color:rgb(0,0,0);font-weight:bold;font-style:italic;text-decoration: none}
                    span.cls_004{font-family:Arial,serif;font-size:9.8px;color:rgb(0,0,0);font-weight:bold;font-style:italic;text-decoration: none}
                    div.cls_004{font-family:Arial,serif;font-size:9.8px;color:rgb(0,0,0);font-weight:bold;font-style:italic;text-decoration: none}
                    span.cls_005{font-family:Arial,serif;font-size:11.8px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
                    div.cls_005{font-family:Arial,serif;font-size:11.8px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
                    span.cls_006{font-family:Arial,serif;font-size:11.8px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
                    div.cls_006{font-family:Arial,serif;font-size:11.8px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
                    span.cls_007{font-family:Arial,serif;font-size:11.8px;color:rgb(0,0,0);font-weight:normal;font-style:italic;text-decoration: none}
                    div.cls_007{font-family:Arial,serif;font-size:11.8px;color:rgb(0,0,0);font-weight:normal;font-style:italic;text-decoration: none}
                    -->
                    </style><div style="position:absolute;left:76.89px;top:83.86px" class="cls_008"><span class="cls_008">Ra</span><span class="cls_002">p</span><span class="cls_008">port de l’'.$_POST['CPA'].'</span></div><div style="position:absolute;left:76.89px;top:111.27px" class="cls_009"><span class="cls_009">Administration:</span></div>
                    <div style="position:absolute;left:76.89px;top:138.68px" class="cls_004"><span class="cls_004">Nom du manager: <b>'.$CPAData[0]['managerName'].'</b></span></div>
                    <div style="position:absolute;left:76.89px;top:162.18px" class="cls_004"><span class="cls_004">Nom du contrôleur: <b>'.$stringUserInfo.'</b></span></div>
                    <div style="position:absolute;left:76.89px;top:186.65px" class="cls_004"><span class="cls_004">Date du contrôle: <b>'.$CPAData[0]['Date'].'</b></span></div>
                    <div style="position:absolute;left:76.89px;top:222.87px" class="cls_009"><span class="cls_009">Entretien:</span></div>
                    <div style="position:absolute;left:76.89px;top:249.30px" class="cls_005"><span class="cls_005">Système de ventilation :</span></div>
                    <div style="position:absolute;left:94.51px;top:276.71px" class="cls_006"><span class="cls_006">•</span><span class="cls_007">  Le tuyau est-il intact ? <b>'.$CPAData[0]['Pipe'].'</b></span></div>
                    <div style="position:absolute;left:94.51px;top:291.39px" class="cls_006"><span class="cls_006">•</span><span class="cls_007">  Les plombs sont-ils présents ? <b>'.$CPAData[0]['Fuses'].'</b></span></div>
                    <div style="position:absolute;left:94.51px;top:306.08px" class="cls_006"><span class="cls_006">•</span><span class="cls_007">  Le filtre à gaz est-il emballé dans du plastique ? <b>'.$CPAData[0]['GazFilter'].'</b></span></div>
                    <div style="position:absolute;left:94.51px;top:320.76px" class="cls_006"><span class="cls_006">•</span><span class="cls_007">  Le mode d’emploi est-il à disposition ? <b>'.$CPAData[0]['Guideline'].'</b></span></div>
                    <div style="position:absolute;left:94.51px;top:335.44px" class="cls_006"><span class="cls_006">•</span><span class="cls_007">  La manivelle est-elle présente ? <b>'.$CPAData[0]['Handwheel'].'</b></span></div>
                    <div style="position:absolute;left:76.89px;top:363.83px" class="cls_005"><span class="cls_005">Portes blindées et volets blindés :</span></div>
                    <div style="position:absolute;left:94.51px;top:391.24px" class="cls_006"><span class="cls_006">•</span><span class="cls_007">  Le dispositif d’auto-libération est-il disponible ? <b>'.$CPAData[0]['SelfReleasing'].'</b></span></div>
                    <div style="position:absolute;left:94.19px;top:405.92px" class="cls_007"><span class="cls_007">•  En cas de porte blindée sans seuil, le seuil amovible est-il disponible ? <b>'.$CPAData[0]['Threshold'].'</b></span></div>
                    <div style="position:absolute;left:76.89px;top:433.33px" class="cls_009"><span class="cls_009">Commentaire: <br><br><span class="cls_007">'.$CPAData[0]['Comments'].'</span></span></div>';


    // Instantiation of the PDF
    $html2pdf = new Html2Pdf('P', 'A4', 'fr');
    $html2pdf->writeHTML($content);

    // For testing purpose
    //$html2pdf->output();

    $content_PDF = $html2pdf->output('','S');

    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $mail->Encoding = 'base64';
    $mail->CharSet = 'UTF-8';

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = CONFIG['email']['host'];                // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = CONFIG['email']['username'];            // SMTP username
        $mail->Password   = CONFIG['email']['password'];            // SMTP password
        $mail->SMTPSecure = CONFIG['email']['SMTPSecure'];          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = CONFIG['email']['port'];                // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('cpawebportalmaster@gmail.com', 'CPA Webmaster');

        // Add all address from mailing list
        foreach ($Recipients as $element)
        {
            foreach ($element as $element_value)
            {
                $mail->addAddress($element_value);
            }
        }

        $file_name = $_POST['CPA']." || ".$CPAData[0]['Date'];
        // Add CPA Report as PDF
        $mail->AddStringAttachment($content_PDF, $file_name, 'base64', 'application/pdf');

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "Rapport de l'".$_POST['CPA']." du ".$CPAData[0]['Date'];
        $mail->Body    = $_POST['message'];
        $mail->WordWrap = 78;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

