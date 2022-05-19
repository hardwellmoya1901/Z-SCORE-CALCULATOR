<?php
require_once "../classes/connectNow.php";
require_once "../classes/Ztable.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZScoreCal</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<link rel="icon" href="../assets/calculator.png">

</head>


	<body>
		<link rel="stylesheet" href="../css/style.css">
		<!-- Latest compiled and minified CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<div class="background">
		<div class="topnav" >
			<a href="index.php"><img alt="Calculator" src="../assets/calculator.png"
			width="70" height="70">ZcoreCal</a>
		</div>

	
	<div class="title1">
		<h2 >Z-SCORE CALCULATOR</h2>
	</div>	
	
		
		<div class="container-fluid">

				<div class="singleZ">
					<div class="row" >
						<!-- Inputs-->
						<div class="col-md-6 inputSpace">
							<div class="divInput">
								<form action="" name='calculateZscore' method='post' class="singleI">
								
									<label for="testValue" class="inputN">Test Value:</label>
									<input required type="text" class="form-control " name="testValue" id="testValue" size="4">
									<label for="mean" class="inputN">Mean:</label>
									<input required type="text" class="form-control "  name="mean" id="mean">
									<label for="sd" class="inputN">Standard Deviation:</label>
									<input required type="text" class="form-control "  name="sd" id="sd"><br>
									<button name= "calculate" type="submit" class="button" >Calculate <i  class="fas fa-arrow-circle-right"></i></button>
									<p class="error" id="error1" style="display:none;">Error Message</p>
								</form>
							</div>	
							

						</div>

						<!-- Outputs-->
						<div class="col-md-3 justify-content-center inputSpace">
							<div class="divOutput">
								<h3>Results: </h3>
								<p id="zscore" style="text-align:center;">Z-score:  </p>

								<p id="zvalue" style="text-align:center;">P-value: </p>


								<!-- Probability -->
								<p id="pl" style="text-align:center;">Probability of x &#60;  </p>
								<p id="pg" style="text-align:center;">Probability of x &#62; </p>
								<p id="pb" style="text-align:center;">Probability of  &#60; x &#60;  </p>
							</div>
						
						</div>


						
						<div class="col-md-3 justify-content-center inputSpace">
							<div class="divOutput">
								<!-- Steps -->
								<h3><b>Steps:</b></h3>

								<table style="margin: 0 auto; text-align:center;">
									<tbody>
										<tr>
											<td>Z-score &nbsp;&nbsp;&nbsp;&nbsp;= &nbsp;&nbsp; </td>
										<td>
								
											<table cellpadding="0" cellspacing="0">
												<tbody>
													<tr>
														<td align="center">x - μ</td>
													</tr>

													<tr>
														<td height="1" bgcolor="#000000"> </td>
													</tr>

													<tr>
														<td align="center">σ</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>

									<tr>
										<td align="right">=&nbsp;&nbsp;&nbsp;</td>

										<td>
											<table cellpadding="0" cellspacing="0">
												<tbody>
													<tr>
														<td align="center" id="tbup"> </td>
													</tr>
													<tr>
														<td height="1" bgcolor="#000000"></td>
													</tr>
													<tr>
														<td align="center" id="tbdown"></td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>

									<tr></tr>
									<tr>
										<td align="right">=&nbsp;&nbsp;&nbsp;</td>
										<td id="tbzscore"></td>
									</tr>
									</tbody>
								</table>

								<br>

								<p style="text-align:center;">P-Value from Z-Table:</p>
								<p style="text-align:center;" id="lz">P(x < ) = </p>
								<p style="text-align:center;" id="gz">P(x > ) = </p>
								<p style="text-align:center;" id="bz">P(5 < x < ) = </p>
							</div>
						</div>


					</div>

				</div>
				
				
				<br>
				<div class="title2">
					<h2>CALCULATE PROPORTION BETWEEN TWO RAW SCORES</h2>
				</div>


				<!-- Calculate Proportion Between Two Scores-->
				

				<div style="margin-top:100px;" class="singleZ">

					<div class="row">
						<!-- Inputs-->
						<div class="col-md-6 inputSpace">
							<div class="divInput">
								<form action="" name='calculateBetween' method='post' class="singleI">
									<label for="" class="inputN" >First Test Value:</label>
									<input required type="text" class="form-control" name="ftestValue" id="ftestValue">

									<label for="" class="inputN">Second Test Value:</label>
									<input required type="text" class="form-control" name="stestValue" id="stestValue">

									<label for="" class="inputN">Mean</label>
									<input required type="text"class="form-control"  name="bmean" id="bmean">
									<label for="" class="inputN">Standard Deviation</label>
									<input required type="text"class="form-control"  name="bsd" id="bsd"><br>
									<button name="bcalculate" type="submit"class="button">Calculate  <i class="fas fa-arrow-circle-right"></i></button>
									<p class="error" id="error2"  style="display:none;">Error Message</p>
								</form>
								
							</div>

						</div>

						<!-- Outputs-->

						<div class="col-md-3 justify-content-center inputSpace">
							<div class="divOutput">
								<h3>Results: </h3>
								<p id="fzscore"  style="text-align:center;">First Z-score: </p>
								<p id="fzvalue"  style="text-align:center;">P-value: </p>
								<!-- Probability -->
								<p id="fpl"  style="text-align:center;">Probability of x &#60;  </p>
								<p id="fpg"  style="text-align:center;">Probability of x &#62;  </p>

								<br>

								<p id="szscore"  style="text-align:center;">Second Z-score: </p>
								<p id="szvalue"  style="text-align:center;">P-value: </p>
								<!-- Probability -->
								<p id="spl"  style="text-align:center;">Probability of x &#60;  </p>
								<p id="spg"  style="text-align:center;">Probability of x &#62;  </p>

								<br><br>

								<!-- Probability between the two raw scores-->
								<p id="bpb"  style="text-align:center;">Probability of  &#60; x &#60;  </p>
							</div>
						</div>

					

						
						<div class="col-md-3 justify-content-center inputSpace">
							<div class="divOutput">

									<!-- Steps -->
									<h3><b>Steps:</b></h3>

									<!-- First Zscore-->
									<h3 style="padding-bottom:0.5em;">First Z-score</h3>
									<table style="margin: 0 auto; text-align:center;">
										<tbody>
											<tr>
												<td>Z-score &nbsp;&nbsp;&nbsp;&nbsp;= &nbsp;&nbsp; </td>
											<td>
									
												<table cellpadding="0" cellspacing="0">
													<tbody>
														<tr>
															<td align="center">x - μ</td>
														</tr>

														<tr>
															<td height="1" bgcolor="#000000"> </td>
														</tr>

														<tr>
															<td align="center">σ</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>

										<tr>
											<td align="right">=&nbsp;&nbsp;&nbsp;</td>

											<td>
												<table cellpadding="0" cellspacing="0">
													<tbody>
														<tr>
															<td align="center" id="ftbup"> </td>
														</tr>
														<tr>
															<td height="1" bgcolor="#000000"></td>
														</tr>
														<tr>
															<td align="center" id="ftbdown"></td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>

										<tr>
											<td align="right">=&nbsp;&nbsp;&nbsp;</td>
											<td id="ftbzscore"></td>
										</tr>
										</tbody>
									</table>

									<br>

									<!-- Second Zscore-->
									<h3 style="padding-bottom:0.5em;">Second Z-score</h3>
									<table style="margin: 0 auto; text-align:center;">
										<tbody>
											<tr>
												<td>Z score &nbsp;&nbsp;&nbsp;&nbsp;= &nbsp;&nbsp; </td>
											<td>
									
												<table cellpadding="0" cellspacing="0">
													<tbody>
														<tr>
															<td align="center">x - μ</td>
														</tr>

														<tr>
															<td height="1" bgcolor="#000000"> </td>
														</tr>

														<tr>
															<td align="center">σ</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>

										<tr>
											<td align="right">=&nbsp;&nbsp;&nbsp;</td>

											<td>
												<table cellpadding="0" cellspacing="0">
													<tbody>
														<tr>
															<td align="center" id="stbup"> </td>
														</tr>
														<tr>
															<td height="1" bgcolor="#000000"></td>
														</tr>
														<tr>
															<td align="center" id="stbdown"></td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>

										<tr>
											<td align="right">=&nbsp;&nbsp;&nbsp;</td>
											<td id="stbzscore"></td>
										</tr>
										</tbody>
									</table>

								<br>
								<p style="text-align:center;">P-Value from Z-Table:</p>
								<p style="text-align:center;" id="flz">P(x < ) = </p>
								<p style="text-align:center;" id="slz">P(x < ) = </p>
								<br>
								<p style="text-align:center;" id="tdbz">Proportion between </p>
								<p style="text-align:center;" id="dbz">P( < x < ) = </p>
							</div>
						</div>


					</div>
				
				</div>

		</div>
	</div>



<?php 
    if(isset($_POST['calculate'])){
        $calculate = new Ztable();
        $calculate -> CalculateZscore();
    }

    if(isset($_POST['bcalculate'])){
        $bcalculate = new Ztable();
        $bcalculate -> CalculateBetween();
    }
?>
</body>
</html>

