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
                                            <?php
                                            while ($row = pg_fetch_row($result)) {
                                                echo "<option value=".$row[1].">".$row[0]." (". $row[2].", ".$row[3].")"."</option>";
                                            }
                                            ?>
									    </select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<H1>Arrivé</H1>
                                    <select name="arrive" id="arrive" multiple multiselect-search="true" multiselect-select-all="false" multiselect-max-items="3" onchange="console.log(this.selectedOptions)" style="max-width:90%" class="form-control" required>
                                        <?php

                                        pg_result_seek($result, 0);

                                        while ($row = pg_fetch_row($result)) {
                                            echo "<option value=".$row[1].">".$row[0]."(". $row[2].", ".$row[3].")"."</option>";
                                        }
                                        ?>
                                    </select>
								</div>
							</div>
							</div>							
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Departing</span>
												<input class="form-control" type="date" name="departureDate" id="departureDate" required>
										</div>
									</div>
								<div class="col-md-6">
									<div class="form-group">
										<span class="form-label">Returning</span>
											<input class="form-control" type="date" name="returningDate" required>
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
