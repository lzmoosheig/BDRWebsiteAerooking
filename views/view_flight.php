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
</style>

<!-- CONTENT -->
<div class="section-center">
    <div class="container" style="margin-top: 200px">
        <div class="row">

            <!-- Type de trajet, classes et bagages -->
            <div class="booking-form">
                <form action="index.php?action=getFlight" method="post">
                    <div class="row">
                        <!-- Type de trajet -->
                        <div class="col-md-3">
                            <label for="allerRetour"> Type de trajet:</label>
                            <select name="allerRetour"  id="allerRetour" class="dropdownStyle">
                                <option value="simple"> Aller Simple </option>
                                <option value="allerretour"> Aller-Retour </option>
                            </select>
                        </div>

                        <!-- Classes -->
                        <div class="col-md-3">
                            <label for="allerRetour"> Classe:</label>
                            <select name="allerRetour"  id="allerRetour" class="dropdownStyle">
                                <option value="economy"> Economie</option>
                                <option value="premiumeconomy"> Economie Premium </option>
                                <option value="business"> Affaire </option>
                                <option value="first"> Première </option>
                            </select>
                        </div>

                        <!-- Bagages -->
                        <div class="col-md-3">
                            <label for="allerRetour"> Bagages:</label>
                            <div class="dropdown">
                                <input type="text" id="droptxt" class="list" readonly/>
                                <div id="content" class="content">
                                    <div class="list">
                                        <input type="checkbox" id="aMain" class="list" value="aMain" />
                                        <label for="aMain" class="list">A main </label>
                                        <input type="hidden" class="list quantity" min="1" value="1" />
                                    </div>

                                    <div class="list">
                                        <input type="checkbox" id="enSoute" class="list" value="enSoute" />
                                        <label for="enSoute" class="list">En soute </label>
                                        <input type="hidden" class="list quantity" min="1" value="1" />
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
                                <select name="depart" id="depart" multiple multiselect-search="true" multiselect-select-all="false" multiselect-max-items="3" onchange="console.log(this.selectedOptions)" style="max-width:90%" class="form-control" required>
                                    <option value="CDG"<?php if (isset($_POST['depart']) && $_POST['depart']=="CDG") echo "selected";?>>Charles de Gaulle (Paris, France)</option>
                                    <option value="ORY">Orly (Paris, France)</option>
                                    <option value="JFK">John F. Kennedy (New York, États-Unis)</option>
                                    <option value="LGA">LaGuardia (New York, États-Unis)</option>
                                    <option value="LHR">Heathrow (Londres, Royaume-Uni)</option>
                                    <option value="LGW">Gatwick (Londres, Royaume-Uni)</option>
                                    <option value="NRT">Narita (Tokyo, Japon)</option>
                                    <option value="HND">Haneda (Tokyo, Japon)</option>
                                    <option value="GRU">Guarulhos (Sao Paulo, Brésil)</option>
                                    <option value="SYD">Sydney (Sydney, Australie)</option>
                                    <option value="DXB">Dubaï (Dubaï, Émirats Arabes Unis)</option>
                                    <option value="IST">Atatürk (Istanbul, Turquie)</option>
                                    <option value="SAW">Sabiha Gökçen (Istanbul, Turquie)</option>
                                    <option value="PVG">Pudong (Shanghai, Chine)</option>
                                    <option value="SHA">Hongqiao (Shanghai, Chine)</option>
                                    <option value="YYZ">Pearson International (Toronto, Canada)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Arrivée -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <H1>Arrivé</H1>
                                <select name="arrive" id="arrive" multiple multiselect-search="true" multiselect-select-all="false" multiselect-max-items="3" onchange="console.log(this.selectedOptions)" style="max-width:90%" class="form-control" required>
                                    <option value="CDG">Charles de Gaulle (Paris, France)</option>
                                    <option value="ORY">Orly (Paris, France)</option>
                                    <option value="JFK">John F. Kennedy (New York, États-Unis)</option>
                                    <option value="LGA">LaGuardia (New York, États-Unis)</option>
                                    <option value="LHR">Heathrow (Londres, Royaume-Uni)</option>
                                    <option value="LGW">Gatwick (Londres, Royaume-Uni)</option>
                                    <option value="NRT">Narita (Tokyo, Japon)</option>
                                    <option value="HND">Haneda (Tokyo, Japon)</option>
                                    <option value="GRU">Guarulhos (Sao Paulo, Brésil)</option>
                                    <option value="SYD">Sydney (Sydney, Australie)</option>
                                    <option value="DXB">Dubaï (Dubaï, Émirats Arabes Unis)</option>
                                    <option value="IST">Atatürk (Istanbul, Turquie)</option>
                                    <option value="SAW">Sabiha Gökçen (Istanbul, Turquie)</option>
                                    <option value="PVG">Pudong (Shanghai, Chine)</option>
                                    <option value="SHA">Hongqiao (Shanghai, Chine)</option>
                                    <option value="YYZ">Pearson International (Toronto, Canada)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Choix des dates -->
                    <div class="row">
                        <!-- Départ -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="form-label">Departing</span>
                                <input class="form-control" type="date" required/>
                            </div>
                        </div>

                        <!-- Arrivée -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="form-label">Returning</span>
                                <input class="form-control" type="date" required/>
                            </div>
                        </div>
                    </div>

                    <!-- Afficher les vols -->
                    <div class="form-btn">
                        <button class="submit-btn">Show flights</button>
                    </div>

                    <!-- Affichage des filtres -->
                    <div class="row">
                        <h1> Voici la liste des vols disponible selon les critères: </h1><br>
                        <h3><b> Filtrer: </b></h3>
                        <h4> Par prix: </h4><br>

                        <!-- Fourchette de prix -->
                        <div class="row-md-12">
                            <div class="col-md-4">
                                <h4> Fourchette: </h4>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="slider-range"></div>
                                        </div>
                                    </div>

                                    <div class="row slider-labels">
                                        <div class="col-xs-6 caption">
                                            <strong>Min:</strong> <span id="slider-range-value1"></span>
                                        </div>
                                        <div class="col-xs-6 text-right caption">
                                            <strong>Max:</strong> <span id="slider-range-value2"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form>
                                                <input type="hidden" name="min-value" value="">
                                                <input type="hidden" name="max-value" value="">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Croissant / décroissant -->
                            <div class="col-md-2">
                                <label class="container">Croissant
                                    <input type="radio" checked="checked" name="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container">Décroissant
                                    <input type="radio" name="radio">
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <!-- Filtre par compagnie -->
                            <h4> Par compagnie: </h4>
                            <div class="col-md-2">
                                <select name="compagnie"  id="compagnie" class="dropdownStyle">
                                    <option value="swissair"> Swiss Air</option>
                                    <option value="airfrance"> Air france </option>
                                    <option value="skyexpress"> Sky Express </option>
                                    <option value="sunexpress"> Sun Express </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="row-md-12">
                            <table>
                                <tr>
                                    <td>
                                        <h4> Escales: </h4>
                                        <table>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" id="direct" name="direct" checked/>
                                                    <label for="direct">Vol direct</label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <input type="checkbox" id="onestopover" name="onestopover"/>
                                                    <label for="onestopover">Une escale</label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <input type="checkbox" id="twostopover" name="twostopover"/>
                                                    <label for="twostopover">Deux escales</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h4> Temps de voyage: </h4>
                                                    <input type="number" id="tempsvoyage" name="tempsvoyage" step="1" placeholder="Nombre d'heures max"/>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- COLLER LE CODE ICI -->
                    </div>
                </form>
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

<script>
const rangeInput = document.querySelectorAll(".range-input input"),
    priceInput = document.querySelectorAll(".price-input input"),
    range = document.querySelector(".slider .progress");
let priceGap = 1000;

priceInput.forEach((input) => {
    input.addEventListener("input", (e) => {
        let minPrice = parseInt(priceInput[0].value),
            maxPrice = parseInt(priceInput[1].value);

        if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
            if (e.target.className === "input-min") {
                rangeInput[0].value = minPrice;
                range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
            } else {
                rangeInput[1].value = maxPrice;
                range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
            }
        }
    });
});

rangeInput.forEach((input) => {
    input.addEventListener("input", (e) => {
        let minVal = parseInt(rangeInput[0].value),
            maxVal = parseInt(rangeInput[1].value);

        if (maxVal - minVal < priceGap) {
            if (e.target.className === "range-min") {
                rangeInput[0].value = maxVal - priceGap;
            } else {
                rangeInput[1].value = minVal + priceGap;
            }
        } else {
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
            range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
            range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
        }
    });
});
</script>

<script src="jquery-3.6.3.min.js" ></script>
<script src="priceSlider.js" ></script>

</div>

<?php $contenu = ob_get_clean(); // Stocke la page dans la variable
require "layout.php";
?>
