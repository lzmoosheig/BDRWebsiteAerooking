<?php
/**
 * Created by PhpStorm.
 * User: Android
 * Date: 02.05.2018
 * Time: 21:14
 */

/**
 * getBD: This function will be used to connect to the local DB: "testBDR"
 * @return false|PDO|resource
 */
function getBD()
{
    // Connect to local DB

    $db_connection = pg_connect("host=localhost dbname=testBDR user=postgres password=");
    if ($db_connection) {
        echo 'Connection attempt succeeded.';
    } else {
        echo 'Connection attempt failed.';
    }
    return $db_connection;
}

/**
 * sendQuery: This function will be used for every SQL request (Secured)
 * @param $query - request
 * @param array $args - all args in array to avoid ' & " issues
 * @return PDOStatement
 */
function sendQuery(string $query, $args = array())
{
    $dataBase = getBD();

    // It's better to make prepared queries but it doesn't work atm

    //$prepareQuery = $dataBase->pg_prepare($dataBase,"my_query",$query);
    //$prepareQuery->pg_execute($dataBase, "my_query",array());


    $result = pg_query($dataBase, $query);

    //$result = $prepareQuery;
    return $result;

}

/* Multiple queries in one statement example
 *
 *
 *
 * $sql = "SELECT * FROM table1; SELECT * FROM table2;";

if (mysqli_multi_query($conn, $sql)) {
    do {

if ($result = mysqli_store_result($conn)) {
    while ($row = mysqli_fetch_row($result)) {
        printf("%s\n", $row[0]);
    }
    mysqli_free_result($conn);
}

if (mysqli_more_results($conn)) {
    printf("-----------------\n");
}
} while (mysqli_next_result($conn));
}
 *
 *
 *
 * */

/**
 * getUser: This function will be used for getting User's pwd and mail address
 * @param $mail
 * @return PDOStatement
 */
function getUser($mail)
{
    $user = sendQuery("SELECT Password, MailAddress FROM users WHERE MailAddress=:mailCheck", array("mailCheck"=>$mail));

    return $user;
}

function makeReservation($resdata)
{
    extract($resdata);

    // TODO

}

function getAirportName()
{
    $airportsInfo = sendQuery("SELECT Aéroport.nom, Aéroport.diminutif, Aéroport.nomville, Pays.nom from aéroport 
INNER JOIN ville on Aéroport.nomville = Ville.nom INNER JOIN Pays on Ville.codepays = Pays.codealpha3  ");
    return $airportsInfo;
}

function getallFlight($aeroport)
{
    extract($aeroport);

    $string = "";

    foreach ($depart as &$value)
    {
        $string = $string.$value.',';
    }

    $string = rtrim($string, ',');

    echo $string;

    $query = "SELECT aéroport.diminutif, vol.nomaéroportdépart, vol.nomaéroportarrivée, compagnie.nom as Compagnie, vol.dateetheurededépart, vol.dateetheuredarrivée, vol.prix
 FROM vol inner join avion on vol.idavion = avion.id inner join compagnie on avion.nomcompagnie = compagnie.nom 
 inner join aéroport on vol.nomaéroportdépart = aéroport.nom
 WHERE aéroport.diminutif = ANY("."'{".$string."}'".")";

    echo $query;



    $flightsInfo = sendQuery($query);


    return $flightsInfo;
}

function createUser($userData)
{
    extract($userData);
    // $email et $pswd
    //sendQuery("INSERT INTO Rooms (Name, LightState, DoorsState, Shelters_idShelters) VALUES ('$Name', $lightState, $doorState, $idShelter);");

    $user = sendQuery("INSERT INTO compte (mail,motdepasse) VALUES ('$email','$pswd')");
}

/**
 * getUserInfo: This function will be used for getting Firstname and Lastname of a user
 * @param $mail
 * @return PDOStatement
 */
function getUserInfo($mail)
{
    $user = sendQuery("SELECT Firstname, Lastname FROM users WHERE MailAddress=:mailCheck", array("mailCheck"=>$mail));

    return $user;
}

/**
 * compareMail: This function will be used to compare users' mail during login
 * @param $mailCheck
 * @return PDOStatement
 */
function compareMail($mailCheck)
{
    $resultat = sendQuery("SELECT eMail FROM Utilisateurs WHERE MailAddress = :mailCheck", array("mailCheck"=>$mailCheck));

    return $resultat;
}

/**
 * getUserID: This function will be used to get the user's ID
 * @param $username
 * @return PDOStatement
 */
function getUserID($username)
{
    $resultat = sendQuery("SELECT idUsers FROM users WHERE MailAddress = :username",array("username"=>$username));

    return $resultat;
}

function getAllCompanies()
{
    $resultat = sendQuery("SELECT * FROM compagnie");

    return $resultat;
}

/**
 * GetShelterID: This function will be used to get the shelter's ID
 * @param $shelterName
 * @return PDOStatement
 */
function GetShelterID($shelterName)
{
    $resultats = sendQuery("SELECT idShelters FROM shelters WHERE Sheltersname = :shelterName", array("shelterName"=>$shelterName));
    return $resultats;
}

/**
 * GetRecipientID: This function will be used to get the recipient's ID
 * @param $MailAddress
 * @return PDOStatement
 */
function GetRecipientID($MailAddress)
{
    $resultats = sendQuery("SELECT idRecipients FROM Recipients WHERE MailAddress = :MailAddress ", array("MailAddress"=>$MailAddress));
    return $resultats;
}

/**
 * GetMailingListID: This function will be used to get a MailingList ID
 * @param $mailingList
 * @return PDOStatement
 */
function GetMailingListID($mailingList)
{
    $resultats = sendQuery("SELECT idMailingList FROM MailingList WHERE Name  = :name ", array("name"=>$mailingList));
    return $resultats;
}

/**
 * createNewShelter: This function will be used to create a new Shelter
 * @param $data
 */
function createNewShelter($data)
{
    extract($data);

    sendQuery("INSERT INTO Shelters (Sheltersname, nbRooms, managerName, KitchenState, HallState, DoorsState, LightsState, Region, Municipalities) VALUES ('".$sheltername."', :nbrooms, :managername, :kitchenstate, :hallstate, :doorsstate, :lightstate, :region, :municipalities);",array("nbrooms" => $nbRooms, "managername" => $managerName,"kitchenstate" => $KitchenState,"hallstate" => $HallState,"doorsstate" => $DoorsState,"lightstate" => $LightsState,"region" => $region,"municipalities" => $municipalities));
}

/**
 * getAllSheltersName: This function will be used to get All Shelter name from Shelters table
 * @return PDOStatement
 */
function getAllSheltersName()
{
    $resultats = sendQuery("SELECT Sheltersname FROM Shelters");

    return $resultats;
}

/**
 * getNbRooms: This function will be used to get the number of Rooms by Shelter
 * @param $shelterName
 * @return PDOStatement
 */
function getNbRooms($shelterName)
{
    $resultats = sendQuery("SELECT nbRooms FROM Shelters WHERE Sheltersname = :shelterName",array("shelterName" => $shelterName));

    return $resultats;
}

/**
 * getNameRooms: This function will be used to get all Rooms name for a selected shelter
 * @param $shelterID
 * @return PDOStatement
 */
function getNameRooms($shelterID)
{
    $resultats = sendQuery("SELECT Name FROM Rooms WHERE Shelters_idShelters = :shelterID",array("shelterID" => $shelterID));

    return $resultats;
}

/**
 * fillRoomsState: This function will be used to fill the "Rooms" table with all states data
 * @param $lightState
 * @param $doorState
 * @param $Name
 */
function fillRoomsState($lightState, $doorState, $Name)
{
    sendQuery("UPDATE Rooms SET LightState = :lightstate, DoorsState = :doorstate WHERE Name = :name",array("lightstate"=>$lightState, "doorstate"=>$doorState, "name"=>$Name));
}

/**
 * fillNewRoomState: This function will be used to fill the "Rooms" table with all states data for new shelter's room
 * @param $lightState
 * @param $doorState
 * @param $Name
 * @param $idShelter
 */
function fillNewRoomState($lightState, $doorState, $Name, $idShelter)
{
    sendQuery("INSERT INTO Rooms (Name, LightState, DoorsState, Shelters_idShelters) VALUES ('$Name', $lightState, $doorState, $idShelter);");
}

/**
 * addRecipient: This function will be used to fill the "Recipients" table
 * @param $recipient
 */
function addRecipient($recipient)
{
    sendQuery("INSERT INTO `Recipients` (`MailAddress`) VALUES ('$recipient');");
}

/**
 * This function will be used for
 * @param $name
 */
function addMailingList($name)
{
    $result = getUserID($_SESSION["user"]['MailAddress']);
    $userID = $result->fetch(PDO::FETCH_ASSOC);
    $userID = $userID["idUsers"];

    sendQuery("INSERT INTO `MailingList` (`Name`, `Users_idUsers`) VALUES ('$name', '$userID');");
}

/**
 * This function will be used for
 * @param $MailingList
 * @return PDOStatement
 */
function verifyMailingList($MailingList)
{
    $result = getUserID($_SESSION["user"]['MailAddress']);
    $userID = $result->fetch(PDO::FETCH_ASSOC);

    $results = sendQuery("SELECT `Name` FROM MailingList WHERE `Users_idUsers` = :userid AND Name = :name",array("userid"=> $userID["idUsers"], "name" => $MailingList));

    return $results;
}

/**
 * This function will be used for
 * @param $Sheltername
 * @return PDOStatement
 */
function verifyShelterName($Sheltername)
{
    $results = sendQuery("SELECT `Sheltersname` FROM Shelters	WHERE `Sheltersname`= :name",array("name"=> $Sheltername));

    return $results;
}

/**
 * This function will be used for
 * @param $MailAddress
 * @return PDOStatement
 */
function verifyRecipient($MailAddress)
{
    $result = sendQuery("SELECT `MailAddress` FROM Recipients WHERE `MailAddress`= :MailAddress",array("MailAddress" => $MailAddress));

    return $result;
}

/**
 * This function will be used for
 * @param $idRecipient
 * @param $idMailingList
 */
function fillRecipientMailingList($idRecipient,$idMailingList)
{
    sendQuery("INSERT INTO `Recipients_has_MailingList` (`Recipients_idRecipients`, `MailingList_idMailingList`) VALUES ('$idRecipient', '$idMailingList');");
}

/**
 * This function will be used for
 * @param $Data
 */
function addCPAReport($Data)
{
    extract($Data);

    // Get user & shelter ID
    $result = getUserID($_SESSION['user']['MailAddress']);
    $userID = $result->fetch(PDO::FETCH_ASSOC);
    $userID = $userID["idUsers"];

    $result = getShelterID($ShelterName);
    $IDshelter = $result->fetch(PDO::FETCH_ASSOC);
    $IDshelter = $IDshelter["idShelters"];

    $Date = date("Y-m-d");


    sendQuery("INSERT INTO `cpa` (`Pipe`, `Fuses`, `GazFilter`, `Guideline`, `Handwheel`, `SelfReleasing`, `Threshold`, `Comments`, `Users_idUsers`, `Shelters_idShelters`,`Date`) VALUES ($Pipe,$Fuses,$GazFilter,$Guideline,$Handwheel,$SelfReleasing,$Threshold,'$message',$userID,$IDshelter,'$Date');");
}

/**
 * This function will be used for
 * @param $pass
 * @param $mail
 * @return bool
 */
function comparePassword($pass,$mail)
{
    $result = sendQuery("SELECT Password FROM Users WHERE MailAddress= :mailaddress",array("mailaddress"=>$mail));

    $password = $result->fetch(PDO::FETCH_ASSOC);

    if ($password["Password"] == $pass)
    {
        return true;
    }
    else return false;
}

/**
 * This function will be used for
 * @return PDOStatement
 */
function getAllSheltersState()
{
    $result = sendQuery("SELECT KitchenState, HallState, DoorsState, LightsState FROM Shelters");

    return $result;
}

/**
 * This function will be used for
 * @param $newpass
 * @param $mail
 */
function changePwd($newpass, $mail)
{
    $result = sendQuery("UPDATE Users SET Password = :pass WHERE MailAddress = :mail",array("pass"=>$newpass, "mail"=>$mail));
}

/**
 * This function will be used for
 * @param $user
 * @return PDOStatement
 */
function getCPAbyUser($user)
{
    $results = getUserID($user);
    $userID = $results->fetch(PDO::FETCH_ASSOC);

    $results = sendQuery("SELECT Shelters.Sheltersname, CPA.Date, Shelters.Municipalities
                FROM CPA
                INNER JOIN Shelters
                WHERE CPA.Shelters_idShelters = Shelters.idShelters AND CPA.Users_idUsers = :iduser",array("iduser"=>$userID["idUsers"]));

    return $results;
}

/**
 * This function will be used for
 * @param $name
 * @return PDOStatement
 */
function getCPAData($name)
{
    $results = sendQuery("SELECT `Pipe`,`Fuses`,`GazFilter`,`Guideline`,`Handwheel`,`SelfReleasing`,`Threshold`,`Comments`,CPA.Date,Shelters.managerName FROM CPA INNER JOIN Shelters WHERE CPA.Shelters_idShelters = Shelters.idShelters AND Shelters.Sheltersname =  :name",array("name"=>$name));

    return $results;
}

/**
 * This function will be used for
 * @param $user
 * @return PDOStatement
 */
function getMailingListbyUser($user)
{
    $results = getUserID($user);
    $userID = $results->fetch(PDO::FETCH_ASSOC);

    $results = sendQuery("SELECT `Name` FROM MailingList WHERE `Users_idUsers`= :iduser",array("iduser"=>$userID["idUsers"]));

    return $results;

}

/**
 * This function will be used for
 * @param $mailinglist
 * @return PDOStatement
 */
function getRecipients($mailinglist)
{
    $results = sendQuery("SELECT `MailAddress` FROM Recipients INNER JOIN Recipients_has_MailingList INNER JOIN MailingList ON Recipients.idRecipients = Recipients_has_MailingList.Recipients_idRecipients AND MailingList.idMailingList = Recipients_has_MailingList.MailingList_idMailingList WHERE MailingList.Name = :mailinglist",array("mailinglist" => $mailinglist));

    return $results;
}

