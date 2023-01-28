<?php
/**
 * Created by PhpStorm.
 * User: Léo Zmoos
 * Date: 23.01.2023
 */

$titre = "BDR - Aerooking";
// ouvre la mémoire tampon
ob_start();
?>
<head>
    <style>
        tr.spaceUnder>td {
            padding-bottom: 1em;
        }
    </style>
</head>
<!-- CONTENT -->
<div class="section-center">
    <div class="container" style="margin-top: 200px">
        <div class="row">
            <!-- Type de trajet, classes et bagages -->
            <div class="booking-form">
                <form action="index.php?action=reserveFlight" method="post">
                    <div class="row">
                        <h1>Réservation du vol:</h1>
                        <span></span>
                        <span><br></span>
                        <h4>Veuillez renseigner les informations des voyageurs (max 10):</h4>
                        <!-- Type de trajet -->
                        <div class="col-md-3">
                            <table>
                                <tr class="spaceUnder">
                                    <th>Voyageur </th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Date de naissance</th>
                                </tr>

                                <tr class="spaceUnder">
                                    <td>1</td>
                                    <td>
                                        <input type="text" name="voyageur1[]" id="voyageur1">
                                    </td>

                                    <td>
                                        <input type="text" name="voyageur1[]">
                                    </td>

                                    <td>
                                        <input type="date" name="voyageur1[]">
                                    </td>
                                </tr>

                                <tr class="spaceUnder" id="voyageur2">
                                    <td>2</td>
                                    <td>
                                        <input type="text" name="voyageur2[]">
                                    </td>

                                    <td>
                                        <input type="text" name="voyageur2[]">
                                    </td>

                                    <td>
                                        <input type="date" name="voyageur2[]">
                                    </td>
                                </tr>

                                <tr class="spaceUnder" id="voyageur3">
                                    <td>3</td>

                                    <td>
                                        <input type="text" name="voyageur3[]">
                                    </td>

                                    <td>
                                        <input type="text" name="voyageur3[]">
                                    </td>

                                    <td>
                                        <input type="date" name="voyageur3[]">
                                    </td>
                                </tr>

                                <tr class="spaceUnder" id="voyageur4">
                                    <td>4</td>
                                    <td>
                                        <input type="text" name="voyageur4[]">
                                    </td>

                                    <td>
                                        <input type="text" name="voyageur4[]">
                                    </td>

                                    <td>
                                        <input type="date" name="voyageur4[]">
                                    </td>
                                </tr>

                                <tr class="spaceUnder" id="voyageur5">
                                    <td>5</td>
                                    <td>
                                        <input type="text" name="voyageur5[]">
                                    </td>

                                    <td>
                                        <input type="text" name="voyageur5[]">
                                    </td>

                                    <td>
                                        <input type="date" name="voyageur5[]">
                                    </td>
                                </tr>

                                <tr class="spaceUnder" id="voyageur6">
                                    <td>6</td>
                                    <td>
                                        <input type="text" name="voyageur6[]">
                                    </td>

                                    <td>
                                        <input type="text" name="voyageur6[]">
                                    </td>

                                    <td>
                                        <input type="date" name="voyageur6[]">
                                    </td>
                                </tr>

                                <tr class="spaceUnder" id="voyageur7">
                                    <td>7</td>
                                    <td>
                                        <input type="text" name="voyageur7[]">
                                    </td>

                                    <td>
                                        <input type="text" name="voyageur7[]">
                                    </td>

                                    <td>
                                        <input type="date" name="voyageur7[]">
                                    </td>
                                </tr>

                                <tr class="spaceUnder" id="voyageur8">
                                    <td>8</td>
                                    <td>
                                        <input type="text" name="voyageur8[]">
                                    </td>

                                    <td>
                                        <input type="text" name="voyageur8[]">
                                    </td>

                                    <td>
                                        <input type="date" name="voyageur8[]">
                                    </td>
                                </tr>

                                <tr class="spaceUnder"  id="voyageur9">
                                    <td>9</td>
                                    <td>
                                        <input type="text" name="voyageur9[]">
                                    </td>

                                    <td>
                                        <input type="text" name="voyageur9[]">
                                    </td>

                                    <td>
                                        <input type="date" name="voyageur9[]">
                                    </td>
                                </tr>

                                <tr class="spaceUnder"  id="voyageur10">
                                    <td>10</td>
                                    <td>
                                        <input type="text" name="voyageur10[]">
                                    </td>

                                    <td>
                                        <input type="text" name="voyageur10[]">
                                    </td>

                                    <td>
                                        <input type="date" name="voyageur10[]">
                                    </td>
                                </tr>


                            </table>

                        </div>

                        <!-- Classes -->
                        <div class="col-md-3">
                        </div>

                        <!-- Bagages -->
                        <div class="col-md-3">
                        </div>
                    </div>

                    <br/>

                    <!-- Afficher les vols -->
                    <div class="form-btn">
                        <button class="submit-btn">Effectuer la réservation</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
    </div>
</div>

<!-- Scripts -->
<script type='text/javascript'>
</script>

<script src="jquery-3.6.3.min.js" ></script>
<script src="priceSlider.js" ></script>

</div>

<?php $contenu = ob_get_clean(); // Stocke la page dans la variable
require "layout.php";
?>
