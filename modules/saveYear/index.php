<?php
  require('../../config/verification.php');
?>

<html>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Historiques des projets</title>

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
		<link rel="stylesheet" href="css/saveYear.css">

	</head>
	<body>

		<a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

		<h1>Sauvegardes</h1>

		<div class="container">
			<div class="make_file" onclick="launch();">Générer fichier</div>
			<ul class="liste_save">
			</ul>
		</div>

		<script type="text/javascript" src="js/saveYear.js"></script>

	</body>
</html>

