<?php
	require('../../config/verification.php');
?>

<html>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>Affecter les soutenances</title>

    <link rel="icon" type="image/png" href="../../assets/icon.png" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  	<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Polices CSS -->
    <link rel="stylesheet" href="../../css/fonts.css">

		<!-- Default CSS -->
    <link rel="stylesheet" href="../../css/default.css">

    <!-- Fullpage form CSS -->
    <link rel="stylesheet" href="../../css/fullpage-form.css">

		<!-- editProject CSS -->
		<link rel="stylesheet" href="css/affectOral.css";>

	</head>
	<body>

		<a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

		<h1>Affecter les groupes à un créneau</h1>

		<div class="container">

			<div class="datepicker"><h3>Choisir le jour de la soutenance</h3></div>

			<div id="content">
				<div id="projets">
					<h2>Projets</h2>
				</div>

				<table id="horaires">
					<tr id="8h">
						<td class="creneau">8h</td>
						<td class="groupes" colspan="2">

						</td>
					</tr>
					<tr id="9h">
						<td class="creneau">9h</td>
						<td class="groupes" colspan="2">

						</td>
					</tr>
					<tr id="10h">
						<td class="creneau">10h</td>
						<td class="groupes" colspan="2">

						</td>
					</tr>
					<tr id="11h">
						<td class="creneau">11h</td>
						<td class="groupes" colspan="2">

						</td>
					</tr>
					<tr id="12h">
						<td class="creneau">12h</td>
						<td class="groupes" colspan="2">

						</td>
					</tr>
					<tr id="13h">
						<td class="creneau">13h</td>
						<td class="groupes" colspan="2">

						</td>
					</tr>
					<tr id="14h">
						<td class="creneau">14h</td>
						<td class="groupes" colspan="2">

						</td>
					</tr>
					<tr id="15h">
						<td class="creneau">15h</td>
						<td class="groupes" colspan="2">

						</td>
					</tr>
					<tr id="16h">
						<td class="creneau">16h</td>
						<td class="groupes" colspan="2">

						</td>
					</tr>
					<tr id="17h">
						<td class="creneau">17h</td>
						<td class="groupes" colspan="2">

						</td>
					</tr>
				</table>
			</div>

		</div>

		<script type="text/javascript" src="js/affectOral.js"></script>

	</body>
</html>
