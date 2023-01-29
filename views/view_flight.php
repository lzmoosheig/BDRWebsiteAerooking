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
                <form action="index.php?action=showFlight" method="post">
                    <div class="row">
                        <!-- Type de trajet -->
                        <div class="col-md-3">
                            <label for="allerRetour"> Type de trajet:</label>
                            <select name="allerRetour"  id="allerRetour" class="dropdownStyle" onchange="onChangeAllerRetour()">
                                <option value="simple"> Aller Simple </option>
                                <option value="allerretour"> Aller-Retour </option>
                            </select>
                        </div>

                        <script>
                            function onChangeAllerRetour() {
                                $('#returning-form').toggle();
                            }

                        </script>

                        <!-- Classes -->
                        <div class="col-md-3">
                            <label for="allerRetour"> Classe:</label>
                            <select name="classe"  id="classe" class="dropdownStyle">
                                <?php
                                while ($row = pg_fetch_row($classes)) {
                                    echo "<option value=".$row[0].">".$row[0].""."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Bagages -->
                        <div class="col-md-3">
                            <label for="nbBagages"> Bagages:</label>
                            <div class="dropdown">
                                <input type="text" id="droptxt" class="list" readonly/>
                                <div id="content" class="content">
                                    <div class="list">
                                        <input type="checkbox" id="aMain" class="list" value="à main" />
                                        <label for="aMain" class="list">A main </label>
                                        <input type="hidden" class="list quantity" min="1" value="1" name="nbBagMain" />
                                    </div>

                                    <div class="list">
                                        <input type="checkbox" id="enSoute" class="list" value="en soute"/>
                                        <label for="enSoute" class="list">En soute </label>
                                        <input type="hidden" class="list quantity" min="1" value="1" name="nbBagSoute" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>

                    <!-- Départ arrivé -->
                    <div class="row">
                        <!-- Départ -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <H1>Départ</H1>
                                <select name="depart[]" id="depart" multiple multiselect-search="true" multiselect-select-all="false" multiselect-max-items="3" onchange="console.log(this.selectedOptions)" style="max-width:90%" class="form-control" required>
                                    <?php
                                    while ($row = pg_fetch_row($airports)) {
                                        echo "<option value=".$row[1].">".$row[0]." (". $row[2].", ".$row[3].")"."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Arrivée -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <H1>Arrivé</H1>
                                <select name="arrive[]" id="arrive" multiple multiselect-search="true" multiselect-select-all="false" multiselect-max-items="3" onchange="console.log(this.selectedOptions)" style="max-width:90%" class="form-control" required>
                                    <?php

                                    pg_result_seek($airports, 0);

                                    while ($row = pg_fetch_row($airports)) {
                                        echo "<option value=".$row[1].">".$row[0]."(". $row[2].", ".$row[3].")"."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Choix des dates -->
                    <div class="row">
                        <!-- Départ -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="form-label">Départ</span>
                                <input class="form-control" type="date" name="dateDepart" required/>
                            </div>
                        </div>

                        <!-- Arrivée -->
                        <div id="returning-form" class="col-md-6" style="display: none;">
                            <div class="form-group">
                                <span class="form-label">Retour</span>
                                <input class="form-control" type="date" name="dateArrivée"/>
                            </div>
                        </div>
                    </div>



                    <!-- Affichage des filtres -->
                    <div class="row">
                        <span><br></span>
                        <h3><b> Filtrer: </b></h3>
                        <h4> Par prix: </h4><br>
                        <div class="col-md-2">
                            <input type="number" name="prixMax" placeholder="Entrer le prix maximum">
                        </div>

                        <!-- Croissant / décroissant -->
                        <div class="col-md-2">
                            <label class="container">Croissant
                                <input type="radio" checked="checked" name="ordre" value="ASC">
                                <span class="checkmark"></span>
                            </label>
                            <label class="container">Décroissant
                                <input type="radio" name="ordre" value="DESC">
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="col-md-2">
                            <h4> Temps de voyage: </h4>
                            <input type="number" id="tempsvoyage" name="tempsvoyage" step="1" placeholder="Nombre d'heures max"/>
                        </div>
                    </div>




                    <span><br></span>
                    <div class="row">
                        <div class="form-btn">
                            <button class="submit-btn">Rechercher un vol</button>
                        </div>
                    </div>
                </form>
                    <!-- Pour tester -->
                <!-- Afficher les vols -->


            </div>
        </div>
        <br>
    </div>
</div>

<!-- Scripts -->
<script>
var txt = document.getElementById( 'droptxt' ),
    content = document.getElementById( 'content' ),
    list = document.querySelectorAll( '.content input[type="checkbox"]' ),
    quantity = document.querySelectorAll( '.quantity' );

txt.addEventListener( 'click', function() {
    content.classList.toggle( 'show' )
} )

// Close the dropdown if the user clicks outside of it
window.onclick = function( e ) {
    if ( !e.target.matches( '.list' ) ) {
        if ( content.classList.contains( 'show' ) ) content.classList.remove( 'show' )
    }
}

list.forEach( function( item, index ) {
    item.addEventListener( 'click', function() {
        quantity[ index ].type = ( item.checked ) ? 'number' : 'hidden';
        calc()
    } )
} )

quantity.forEach( function( item ) {
    item.addEventListener( 'input', calc )
} )

function calc() {
    for ( var i = 0, arr = []; i < list.length; i++ ) {
        if ( list[ i ].checked ) arr.push( quantity[ i ].value + ' x ' + list[ i ].value )
    }

    txt.value = arr.join( ', ' )
}
</script>


<script src="jquery-3.6.3.min.js" ></script>
</div>

<?php $contenu = ob_get_clean(); // Stocke la page dans la variable
require "layout.php";
?>
