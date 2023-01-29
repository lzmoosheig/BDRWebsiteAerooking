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

<!-- CONTENT -->
<div class="section-center">
    <div class="container" style="margin-top: 200px">
        <div class="row">
            <!-- Type de trajet, classes et bagages -->
            <div class="booking-form">
                <h1> Le vol a été ajouté! </h1>
                <a href="index.php?action=viewAdmin"> Retourner sur le panel admin</a>
            </div>
        </div>
        <br>
    </div>
</div>

<!-- Scripts -->
<script src="jquery-3.6.3.min.js" ></script>
<script src="priceSlider.js" ></script>

</div>

<?php $contenu = ob_get_clean(); // Stocke la page dans la variable
require "layout.php";
?>
