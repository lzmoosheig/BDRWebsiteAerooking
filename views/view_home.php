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
					<p>Pour satisfaire tes envies de voyage !</p>
				</div>
			</div>				
			<div class="col-md-6 col-md-offset-1">
				<div class="booking-form">
					<form>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<H1>Départ</H1>
										<select name="field2" id="field2" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="3" onchange="console.log(this.selectedOptions)" style="max-width:90%";>
											<option>Abarth</option>
											<option>Alfa Romeo</option>
											  <option>Aston Martin</option>
											  <option>Audi</option>
											  <option>Bentley</option>
											  <option>BMW</option>
											  <option>Bugatti</option>
											  <option>Cadillac</option>
											  <option>Chevrolet</option>
											  <option>Chrysler</option>
											  <option>Citroën</option>
											  <option>Dacia</option>
											  <option>Daewoo</option>
											  <option>Daihatsu</option>
											  <option>Dodge</option>
											  <option>Donkervoort</option>
											  <option>DS</option>
											  <option>Ferrari</option>
											  <option>Fiat</option>
											  <option>Fisker</option>
											  <option>Ford</option>
											  <option>Honda</option>
											  <option>Hummer</option>
											  <option>Hyundai</option>
											  <option>Infiniti</option>
											  <option>Iveco</option>
											  <option>Jaguar</option>
											  <option>Jeep</option>
											  <option>Kia</option>
											  <option>KTM</option>
											  <option>Lada</option>
											  <option>Lamborghini</option>
											  <option>Lancia</option>
											  <option>Land Rover</option>
											  <option>Landwind</option>
											  <option>Lexus</option>
											  <option>Lotus</option>
											  <option>Maserati</option>
											  <option>Maybach</option>
											  <option>Mazda</option>
											  <option>McLaren</option>
											  <option>Mercedes-Benz</option>
											  <option>MG</option>
											  <option>Mini</option>
											  <option>Mitsubishi</option>
											  <option>Morgan</option>
											  <option>Nissan</option>
											  <option>Opel</option>
											  <option>Peugeot</option>
											  <option>Porsche</option>
											  <option>Renault</option>
											  <option>Rolls-Royce</option>
											  <option>Rover</option>
											  <option>Saab</option>
											  <option>Seat</option>
											  <option>Skoda</option>
											  <option>Smart</option>
											  <option>SsangYong</option>
											  <option>Subaru</option>
											  <option>Suzuki</option>
											  <option>Tesla</option>
											  <option>Toyota</option>
											  <option>Volkswagen</option>
											  <option>Volvo</option>
									</select>	
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group">
									<H1>Arrivé</H1>
									<select name="field2" id="field2" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="3" onchange="console.log(this.selectedOptions)" style="max-width:90%";>
											  <option>Abarth</option>
											  <option>Alfa Romeo</option>
											  <option>Aston Martin</option>
											  <option>Audi</option>
											  <option>Bentley</option>
											  <option>BMW</option>
											  <option>Bugatti</option>
											  <option>Cadillac</option>
											  <option>Chevrolet</option>
											  <option>Chrysler</option>
											  <option>Citroën</option>
											  <option>Dacia</option>
											  <option>Daewoo</option>
											  <option>Daihatsu</option>
											  <option>Dodge</option>
											  <option>Donkervoort</option>
											  <option>DS</option>
											  <option>Ferrari</option>
											  <option>Fiat</option>
											  <option>Fisker</option>
											  <option>Ford</option>
											  <option>Honda</option>
											  <option>Hummer</option>
											  <option>Hyundai</option>
											  <option>Infiniti</option>
											  <option>Iveco</option>
											  <option>Jaguar</option>
											  <option>Jeep</option>
											  <option>Kia</option>
											  <option>KTM</option>
											  <option>Lada</option>
											  <option>Lamborghini</option>
											  <option>Lancia</option>
											  <option>Land Rover</option>
											  <option>Landwind</option>
											  <option>Lexus</option>
											  <option>Lotus</option>
											  <option>Maserati</option>
											  <option>Maybach</option>
											  <option>Mazda</option>
											  <option>McLaren</option>
											  <option>Mercedes-Benz</option>
											  <option>MG</option>
											  <option>Mini</option>
											  <option>Mitsubishi</option>
											  <option>Morgan</option>
											  <option>Nissan</option>
											  <option>Opel</option>
											  <option>Peugeot</option>
											  <option>Porsche</option>
											  <option>Renault</option>
											  <option>Rolls-Royce</option>
											  <option>Rover</option>
											  <option>Saab</option>
											  <option>Seat</option>
											  <option>Skoda</option>
											  <option>Smart</option>
											  <option>SsangYong</option>
											  <option>Subaru</option>
											  <option>Suzuki</option>
											  <option>Tesla</option>
											  <option>Toyota</option>
											  <option>Volkswagen</option>
											  <option>Volvo</option>
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
