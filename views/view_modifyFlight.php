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

<div id="test">

    <style>
        .dropdownStyle {
            padding: 8px;
            width: 300px;
            cursor: pointer;
            box-sizing: border-box
        }

        #droptxt {
            padding: 8px;
            width: 300px;
            cursor: pointer;
            box-sizing: border-box
        }
        .dropdown {
            position: relative;
            display: inline-block
        }
        .content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 200px;
            overflow: auto;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, .2);
            z-index: 1
        }
        .quantity {
            float: right;
            width: 40px
        }
        .content div {
            padding: 10px 15px
        }
        .content div:hover {
            background-color: #ddd
        }
        .show {
            display: block
        }

        /* Functional styling;
         * These styles are required for noUiSlider to function.
         * You don't need to change these rules to apply your design.
         */
        .noUi-target,.noUi-target * {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -ms-touch-action: none;
            touch-action: none;
            -ms-user-select: none;
            -moz-user-select: none;
            user-select: none;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .noUi-target {
            position: relative;
            direction: ltr;
        }

        .noUi-base {
            width: 100%;
            height: 100%;
            position: relative;
            z-index: 1;
            /* Fix 401 */
        }

        .noUi-origin {
            position: absolute;
            right: 0;
            top: 0;
            left: 0;
            bottom: 0;
        }

        .noUi-handle {
            position: relative;
            z-index: 1;
        }

        .noUi-stacking .noUi-handle {
            /* This class is applied to the lower origin when
               its values is > 50%. */
            z-index: 10;
        }

        .noUi-state-tap .noUi-origin {
            -webkit-transition: left 0.3s,top .3s;
            transition: left 0.3s,top .3s;
        }

        .noUi-state-drag * {
            cursor: inherit !important;
        }

        /* Painting and performance;
         * Browsers can paint handles in their own layer.
         */
        .noUi-base,.noUi-handle {
            -webkit-transform: translate3d(0,0,0);
            transform: translate3d(0,0,0);
        }

        /* Slider size and handle placement;
         */
        .noUi-horizontal {
            height: 4px;
        }

        .noUi-horizontal .noUi-handle {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            left: -7px;
            top: -7px;
            background-color: #345DBB;
        }

        /* Styling;
         */
        .noUi-background {
            background: #D6D7D9;
        }

        .noUi-connect {
            background: #345DBB;
            -webkit-transition: background 450ms;
            transition: background 450ms;
        }

        .noUi-origin {
            border-radius: 2px;
        }

        .noUi-target {
            border-radius: 2px;
        }

        .noUi-target.noUi-connect {
        }

        /* Handles and cursors;
         */
        .noUi-draggable {
            cursor: w-resize;
        }

        .noUi-vertical .noUi-draggable {
            cursor: n-resize;
        }

        .noUi-handle {
            cursor: default;
            -webkit-box-sizing: content-box !important;
            -moz-box-sizing: content-box !important;
            box-sizing: content-box !important;
        }

        .noUi-handle:active {
            border: 8px solid #345DBB;
            border: 8px solid rgba(53,93,187,0.38);
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            left: -14px;
            top: -14px;
        }

        /* Disabled state;
         */
        [disabled].noUi-connect,[disabled] .noUi-connect {
            background: #B8B8B8;
        }

        [disabled].noUi-origin,[disabled] .noUi-handle {
            cursor: not-allowed;
        }

        th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #09034a;
            color: white;
        }

        tr.spaceUnder>td {
            padding-bottom: 1em;
        }

    </style>

    <!-- CONTENT -->
    <div class="section-center">
        <div class="container" style="margin-top: 200px">
            <div class="row">
                <!-- Type de trajet, classes et bagages -->
                <div class="booking-form">
                    <form action="index.php?action=reserverVol" method="post">
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
                                    <th>Poids max bagages en soute</th>
                                    <th></th>
                                </tr>


                                <?php

                                while ($row = pg_fetch_row($res)) {
                                    echo "<tr class=\"spaceUnder\">
                                        <td>".$row[0]."</td>
                                        <td><input type=\"number\" value=\"$row[1]\">"."
                                        </td>
                                        <td>'.$row[1].'</td>
                                        <td>'.$row[2].'</td>
                                        <td>'.$row[5].'</td>
                                        <td>'.$row[8].'</td>
                                        <td>'.$row[9].'</td>
                                        </td>
                                    </tr>";
                                }
                                ?>
                            </table>
                        </div>
                        <!-- Pour tester -->
                        <!-- Afficher les vols -->

                    </form>
                </div>
            </div>
            <br>
        </div>
    </div>


</div>

<?php $contenu = ob_get_clean(); // Stocke la page dans la variable
require "layout.php";
?>

