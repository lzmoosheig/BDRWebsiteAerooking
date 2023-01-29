<?php
/**
 * Created by PhpStorm.
 * User: Android
 * Date: 02.05.2018
 * Time: 21:14
 */

/**
 * getBD: This function will be used to connect to the local DB
 * @return false|PDO|resource
 */
function getBD()
{
    // Connect to local DB

    $db_connection = pg_connect("host=postgresql dbname=bdr user=bdr password=bdr");

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
    $user = sendQuery("SELECT mail, motdepasse FROM Compte WHERE mail ="."'$mail'");

    return $user;
}

function makeReservation($resdata, $passengerInfos)
{
    extract($resdata);
    extract($passengerInfos);

    $flag = 'FALSE';

    // $nbBagMain, $nbBagSoute, $allerRetour

    if($allerRetour != "simple")
    {
        $flag = 'TRUE';
    }

    $idVol = $_GET['idVol'];

    $mail = $_SESSION['user'];

    $counterPassenger = 0;

    $query = "INSERT INTO Réservation (mailClient, dateEtHeureRéservation, nbBagagesEnSoute, nbBagagesAMain, allerRetour) 
                VALUES ((SELECT mailCompte FROM Client WHERE mailCompte = "."'$mail'"."),"."DEFAULT".",".$nbBagSoute.",".$nbBagMain.",". $flag.");".
             "INSERT INTO Vol_Réservation (idréservation,idvol) VALUES ((select MAX(id) from Réservation),".$idVol.");";

            foreach ($_POST as $passengersInfos)
            {
                if (!empty($passengersInfos[0]) && !empty($passengersInfos[1]) && !empty($passengersInfos[2])) {
                    $query = $query."INSERT INTO Voyageur (nom, prénom, dateDeNaissance) VALUES(" . "'$passengersInfos[0]'" . "," . "'$passengersInfos[1]'" . "," . "'$passengersInfos[2]'" . ");";
                    $query = $query."INSERT INTO Voyageur_Réservation (idvoyageur, idréservation) VALUES((select MAX(id) from Voyageur),(select MAX(id) from Réservation));";
                    $counterPassenger++;
                }
            }

            $query = $query."INSERT INTO Classe_Réservation (nomclasse, idréservation, places) VALUES ("."'$classe'".", (select MAX(id) from Réservation), $counterPassenger)";

    sendQuery($query);

}

function getAirportName()
{
    $airportsInfo = sendQuery("SELECT Aéroport.nom, Aéroport.diminutif, Aéroport.nomville, Pays.nom from aéroport 
INNER JOIN ville on Aéroport.nomville = Ville.nom INNER JOIN Pays on Ville.codepays = Pays.codealpha3  ");
    return $airportsInfo;
}

function getReservation()
{
    if(isset($_SESSION['user'])) {
        $mail = $_SESSION['user'];

        $query = "SELECT \"DateDeRéservation\",\"NombreDePlacesRéservées\",\"AéroportDeDépart\",\"TempsDeDépart\",\"AéroportDArrivée\",\"TempsDArrivée\",\"IDRéservation\"
            FROM vRéservations
            WHERE \"IDClient\" =" . "'$mail'" . "
            GROUP BY \"DateDeRéservation\",
              \"NombreDePlacesRéservées\",
              \"AéroportDeDépart\",
              \"TempsDeDépart\",
              \"AéroportDArrivée\",
              \"TempsDArrivée\",
              \"IDRéservation\";";
    }

    $result = sendQuery($query);
    return $result;
}

function getPassengerFromRes()
{
    $idRes = $_GET['idRes'];
    $mail = $_SESSION['user'];


    $query = "SELECT \"Nom\",\"Prénom\",\"ClasseDeVol\"
                FROM vRéservations
                WHERE \"IDClient\" ="."'$mail'"." AND "."\"IDRéservation\" =".$idRes." 
                GROUP BY \"Nom\",
                  \"Prénom\",
                  \"ClasseDeVol\";";

    $res = sendQuery($query);
    return $res;
}

function getMultipleFlight()
{
    $idRes = $_GET['idRes'];
    $mail = $_SESSION['user'];

    $query = "SELECT \"NombreDePlacesRéservées\",\"AéroportDeDépart\",\"TempsDeDépart\",\"AéroportDArrivée\",\"TempsDArrivée\",
  \"CompagnieAérienne\"
FROM vRéservations
WHERE \"IDClient\" ="."'$mail'"." AND "."\"IDRéservation\" =".$idRes."
GROUP BY \"NombreDePlacesRéservées\",
  \"TempsDeDépart\",
  \"TempsDArrivée\",
  \"AéroportDeDépart\",
  \"AéroportDArrivée\",
  \"CompagnieAérienne\";";

    $res = sendQuery($query);
    return $res;

}

function getallFlight($aeroport)
{
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


    if($dateArrivée != "")
    {
        $query = "SELECT \"IDVol\", \"AéroportDeDépart\", \"AéroportDArrivée\", \"CompagnieAérienne\", \"TempsDeDépart\", \"TempsDArrivée\", \"PrixDuVol\" from vVols WHERE "."\"ClasseDeVol\""."="."'$classe'"." AND "."\"MaxBagagesAMain\""."-"."\"NombreDeBagagesAMainDéjàRéservés\"".">=".$nbBagMain." AND "."(".
            "\"PoidsMaxEnSoute\""."-"."\"PoidsDesBagagesEnSouteDéjàRéservés\")"."/"."\"PoidsMaxDeBagageEnSoute\"".">".$nbBagSoute." AND "."\"DiminutifDeLAéroportDeDépart\""."="."ANY("."'{".$stringDepart."}'".")".
            " AND "."\"DiminutifDeLAéroportDArrivée\""."="."ANY("."'{".$stringArrive."}'".")"." AND "."\"TempsDeDépart\""." BETWEEN "."'$dateDepart'"." AND "."DATE '$dateDepart'"."+ INTERVAL '24 Hours'"." AND ".
            "\"TempsDArrivée\""." BETWEEN "."'$dateArrivée'"." AND "."DATE '$dateArrivée'"."+ INTERVAL '24 Hours' AND "."\"PrixDuVol\""." BETWEEN "."0"." AND ".$prixMax." AND "."\"CompagnieAérienne\""." LIKE "."'%'".
            " AND "."\"TempsDArrivée\""."-"."\"TempsDeDépart\""."< INTERVAL "."'$tempsvoyage Hour'"." GROUP BY "."\"IDVol\", \"AéroportDeDépart\", \"AéroportDArrivée\", \"CompagnieAérienne\", \"TempsDeDépart\", \"TempsDArrivée\", \"PrixDuVol\""." ORDER BY "."\"PrixDuVol\" ".$ordre."";
    } else {
        $query = "SELECT \"IDVol\",\"AéroportDeDépart\", \"AéroportDArrivée\", \"CompagnieAérienne\", \"TempsDeDépart\", \"TempsDArrivée\", \"PrixDuVol\" from vVols WHERE "."\"ClasseDeVol\""."="."'$classe'"." AND "."\"MaxBagagesAMain\""."-"."\"NombreDeBagagesAMainDéjàRéservés\"".">=".$nbBagMain." AND "."(".
            "\"PoidsMaxEnSoute\""."-"."\"PoidsDesBagagesEnSouteDéjàRéservés\")"."/"."\"PoidsMaxDeBagageEnSoute\"".">".$nbBagSoute." AND "."\"DiminutifDeLAéroportDeDépart\""."="."ANY("."'{".$stringDepart."}'".")".
            " AND "."\"DiminutifDeLAéroportDArrivée\""."="."ANY("."'{".$stringArrive."}'".")"." AND "."\"TempsDeDépart\""." BETWEEN "."'$dateDepart'"." AND "."DATE '$dateDepart'"."+ INTERVAL '24 Hours'"." AND ".
            "\"PrixDuVol\""." BETWEEN "."0"." AND ".$prixMax." AND "."\"CompagnieAérienne\""." LIKE "."'%'".
            " GROUP BY "."\"IDVol\", \"AéroportDeDépart\", \"AéroportDArrivée\", \"CompagnieAérienne\", \"TempsDeDépart\", \"TempsDArrivée\", \"PrixDuVol\""." ORDER BY "."\"PrixDuVol\" ".$ordre."";

    }


    $flightsInfo = sendQuery($query);


    return $flightsInfo;
}


function createFlight($flightInfo)
{
    extract($flightInfo);

    $dateheureDepart =  str_replace("T"," ",$dateheureDepart);
    $dateheureArrive =  str_replace("T"," ",$dateheureArrive);


    $query = "INSERT INTO Vol (idAvion, nomAéroportDépart, nomVilleAéroportDépart, codePaysAéroportDépart, nomAéroportArrivée, nomVilleAéroportArrivée, codePaysAéroportArrivée, dateEtHeureDeDépart, dateEtHeureDArrivée, prix, poidsMaxBagagesEnSoute) VALUES (".$idAvion.", (SELECT nom FROM Aéroport WHERE diminutif = "."'$depart'"."), (SELECT nomVille FROM Aéroport WHERE diminutif ="."'$depart'"."), (SELECT codePays FROM Aéroport WHERE diminutif ="."'$depart'"."),
	(SELECT nom FROM Aéroport WHERE diminutif ="."'$arrive'"."), (SELECT nomVille FROM Aéroport WHERE diminutif ="."'$arrive'"."), (SELECT codePays FROM Aéroport WHERE diminutif = "."'$arrive'"."),"."'$dateheureDepart'".","."'$dateheureArrive'".", (SELECT random_between(30,100)), 23); ";

    sendQuery($query);
}

function getClasses()
{
    $query = "SELECT nom FROM Classe";
    $result = sendQuery($query);

    return $result;
}


/**
 * compareMail: This function will be used to compare users' mail during login
 * @param $mailCheck
 * @return PDOStatement
 */
function compareMail($mailCheck)
{
    $resultat = sendQuery("SELECT mail FROM Compte WHERE mail ="."'$mailCheck'");


    return $resultat;
}


function getAllCompanies()
{
    $resultat = sendQuery("SELECT * FROM compagnie");

    return $resultat;
}

function getAllFlightAdmin()
{
    $query = "select id, idavion, nomaéroportdépart, nomaéroportarrivée, dateetheurededépart, dateetheuredarrivée, prix, poidsmaxbagagesensoute from vol";

    $res = sendQuery($query);

    return $res;

}

function deleteFlight()
{
    $id = $_GET['idVol'];
    $query = "DELETE FROM vol where id =".$id;
    sendQuery($query);
}

function signUP($userdata)
{
    extract($userdata);
    $query = "INSERT INTO compte (mail,motdepasse) VALUES ("."'$email'".","."'$pswd'".")";
    sendQuery($query);
}


/**
 * Fonction pour update les prix de vol périodiquement
 * Cette fonction n'est pas utilisable actuellement
 * @return void
 */
function update_prix_vol()
{
    $db_connection = pg_connect("host=localhost port=5432 dbname=Aerooking");

    $query = "UPDATE vol SET prix = prix + 10 WHERE dateEtHeureDeDépart > CURRENT_DATE";
    sendQuery($query);

    pg_close($db_connection);

    $chrono = new \Cron\CronExpression('0 0 * * 0', new \Cron\FieldFactory);
    $update_event = new \Cron\Event\Event('update_prix_vol', $chrono);
    $schedule = new \Cron\Schedule\CronSchedule();
    $schedule->addEvent($update_event);
    $schedule->run();
}





