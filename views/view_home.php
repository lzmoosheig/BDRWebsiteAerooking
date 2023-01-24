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
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">     
    select {
        width:200px;
    }
</style>

</head>
<div class="section-center">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="booking-cta">
					<h1>Aerooking</h1><br>
					<p>Pour satisfaire vos envies de voyage !</p>
				</div>
			</div>				
			<div class="col-md-6 col-md-offset-1">
				<div class="booking-form">
					<form action="index.php?action=getFlight" method="post">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<H1>Départ</H1>
										<select name="depart" id="depart" multiple multiselect-search="true" multiselect-select-all="false" multiselect-max-items="3" onchange="console.log(this.selectedOptions)" style="max-width:90%" class="form-control" required>
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
		</div>
		</div>



  

<script>
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
</script>
<?php $contenu = ob_get_clean(); // Stocke la page dans la variable
require "layout.php";
?>
