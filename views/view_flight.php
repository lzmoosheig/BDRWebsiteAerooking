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
<html>
<head>
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
</style>

<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<!-- USED FOR DEBUG ONLY
<pre>
<?php var_dump($_POST); ?>
</pre>
-->
<div class="section-center">
	<div class="container">
		<div class="row">				
			<div class="booking-form">
				<form action="index.php?action=getFlight" method="post">
					<div class="row">
						<div class="col-md-3">
						<label for="allerRetour"> Type de trajet:</label> 
							<select name="allerRetour"  id="allerRetour" class="dropdownStyle">
								<option value="simple"> Aller Simple </option>
								<option value="allerretour"> Aller-Retour </option>
							</select>
						</div>
						
						<div class="col-md-3">
						<label for="allerRetour"> Classe:</label> 
							<select name="allerRetour"  id="allerRetour" class="dropdownStyle">
								<option value="economy"> Economie</option>
								<option value="premiumeconomy"> Economie Premium </option>
								<option value="business"> Affaire </option>
								<option value="first"> Première </option>
							</select>
						</div>
						
						<div class="col-md-3">
						<label for="allerRetour"> Bagages:</label> 
							<div class="dropdown">
							<input type="text" id="droptxt" class="list" readonly>
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
					<br>
						<div class="row">
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
											
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<span class="form-label">Departing</span>
										<input class="form-control" type="date" required>
								</div>
							</div>
						<div class="col-md-6">
					<div class="form-group">
						<span class="form-label">Returning</span>
							<input class="form-control" type="date" required>
							</div>
						</div>
					</div>

				<div class="form-btn">
					<button class="submit-btn">Show flights</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

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

<?php $contenu = ob_get_clean(); // Stocke la page dans la variable
require "layout.php";
?>
