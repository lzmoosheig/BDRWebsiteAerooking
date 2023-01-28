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

    $db_connection = pg_connect("host=localhost dbname=testBDR user=postgres password=Coclove22");
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
    var_dump($_POST);
    extract($aeroport);

    $stringDepart = "";

    foreach ($depart as &$value)
    {
        $stringDepart = $stringDepart.$value.',';
    }

    $stringDepart = rtrim($stringDepart, ',');

    $stringArrive = "";

    foreach ($arrive as &$value)
    {
        $stringArrive = $stringArrive.$value.',';
    }

    $stringArrive = rtrim($stringArrive, ',');


    /*
array (size=13)
'allerRetour' => string 'simple' (length=6)
'classe' => string 'economy' (length=7)
'nbBagMain' => string '1' (length=1)
'nbBagSoute' => string '1' (length=1)
'depart' =>
array (size=3)
  0 => string 'SYD' (length=3)
  1 => string 'VIE' (length=3)
  2 => string 'BRU' (length=3)
'arrive' =>
array (size=1)
  0 => string 'VIE' (length=3)
'dateDepart' => string '2023-02-03' (length=10)
'dateArrivée' => string '2023-02-03' (length=10)
'prixMax' => string '1000' (length=4)
'ordre' => string 'ASC' (length=3)
'compagnie' => string 'Air France' (length=10)
'escale' => string 'direct' (length=6)
'tempsvoyage' => string '1000' (length=4)

    select \"AéroportDeDépart\", \"AéroportDArrivée\", \"CompagnieAérienne\", \"TempsDeDépart\", \"TempsDArrivée\", \"PrixDuVol\"  from vVols
group by \"IDVol\", \"AéroportDeDépart\", \"AéroportDArrivée\", \"CompagnieAérienne\", \"TempsDeDépart\", \"TempsDArrivée\", \"PrixDuVol\"


*/


    $query = "SELECT \"AéroportDeDépart\", \"AéroportDArrivée\", \"CompagnieAérienne\", \"TempsDeDépart\", \"TempsDArrivée\", \"PrixDuVol\" from vVols WHERE "."\"ClasseDeVol\""."="."'$classe'"." AND "."\"MaxBagagesAMain\""."-"."\"NombreDeBagagesAMainDéjàRéservés\"".">=".$nbBagMain." AND "."(".
        "\"PoidsMaxEnSoute\""."-"."\"PoidsDesBagagesEnSouteDéjàRéservés\")"."/"."\"PoidsMaxDeBagageEnSoute\"".">".$nbBagSoute." AND "."\"DiminutifDeLAéroportDeDépart\""."="."ANY("."'{".$stringDepart."}'".")".
        "AND "."\"DiminutifDeLAéroportDArrivée\""."="."ANY("."'{".$stringArrive."}'".")"." AND "."\"TempsDeDépart\""." BETWEEN "."'$dateDepart'"." AND "."('$dateDepart'"."+ INTERVAL '1 Day')"." AND ".
        "\"TempsDArrivée\""." BETWEEN "."'$dateArrivée'"." AND "."('$dateArrivée'"."+ INTERVAL '1 Day') AND "."\"PrixDuVol\""." BETWEEN "."0"." AND ".$prixMax." AND "."\"CompagnieAérienne\""."="."'$compagnie'".
        " AND "."\"TempsDArrivée\""."-"."\"TempsDeDépart\""."< INTERVAL "."'1 Hour'"." GROUP BY "."\"IDVol\", \"AéroportDeDépart\", \"AéroportDArrivée\", \"CompagnieAérienne\", \"TempsDeDépart\", \"TempsDArrivée\", \"PrixDuVol\""." ORDER BY "."\"PrixDuVol\" ".$ordre."";

    echo $query;




    /*$query = "SELECT aéroport.diminutif, vol.nomaéroportdépart, vol.nomaéroportarrivée, compagnie.nom as Compagnie, vol.dateetheurededépart, vol.dateetheuredarrivée, vol.prix
 FROM vol inner join avion on vol.idavion = avion.id inner join compagnie on avion.nomcompagnie = compagnie.nom 
 inner join aéroport on vol.nomaéroportdépart = aéroport.nom
 WHERE aéroport.diminutif = ANY("."'{".$string."}'".")";

    echo $query;*/



    $flightsInfo = sendQuery($query);


    return $flightsInfo;
}


function createFlight($flightInfo)
{
    extract($flightInfo);

    $dateheureDepart =  str_replace("T"," ",$dateheureDepart);
    $dateheureArrive =  str_replace("T"," ",$dateheureArrive);


    $query = "INSERT INTO Vol (idAvion, nomAéroportDépart, nomVilleAéroportDépart, codePaysAéroportDépart, nomAéroportArrivée, nomVilleAéroportArrivée, codePaysAéroportArrivée, dateEtHeureDeDépart, dateEtHeureDArrivée, prix, poidsMaxBagagesEnSoute) VALUES ((select MAX(id) from avion
where nomcompagnie ="."'$compagnie'".")".", (SELECT nom FROM Aéroport WHERE diminutif = "."'$depart'"."), (SELECT nomVille FROM Aéroport WHERE diminutif ="."'$depart'"."), (SELECT codePays FROM Aéroport WHERE diminutif ="."'$depart'"."),
	(SELECT nom FROM Aéroport WHERE diminutif ="."'$arrive'"."), (SELECT nomVille FROM Aéroport WHERE diminutif ="."'$arrive'"."), (SELECT codePays FROM Aéroport WHERE diminutif = "."'$arrive'"."),"."'$dateheureDepart'".","."'$dateheureArrive'".", (SELECT random_between(30,100)), 23); ";

    sendQuery($query);

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