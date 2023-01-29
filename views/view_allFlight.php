
<!-- Liste des vols -->
<div class="row">
    <span><br></span>
    <br><h1> Voici la liste des vols disponible selon les critères: </h1><br>
</div>

<div class="row" style="margin-left: 5%;margin-right: 5%">
    <span><br></span>
    <table>
        <tr class="spaceUnder">
            <th>ID Vol</th>
            <th>ID Avion</th>
            <th>Aéroport(s) de départ</th>
            <th>Aéroport(s) d'arrivée</th>
            <th>Heure de départ</th>
            <th>Heure d'arrivée</th>
            <th>Prix</th>
            <th></th>
        </tr>
        <?php

        $_SESSION['post-data'] = $_POST;

        while ($row = pg_fetch_row($allFlight)) {
            echo '<tr class="spaceUnder">
                                        <td>'.$row[0].'</td>
                                        <td>'.$row[1].'</td>
                                        <td>'.$row[2].'</td>
                                        <td>'.$row[3].'</td>
                                        <td>'.$row[4].'</td>
                                        <td>'.$row[5].'</td>
                                        <td>'.$row[6].' .- CHF'."</td>
                                        <td>
                                        </td>
                                        <td>
                                        <a class=\"btn\" href=\"index.php?action=supprimerVol&idVol=$row[0]\"> Supprimer </a>
                                        </td>                           
                                    </tr>";
        }
        ?>
    </table>
</div>


