<?php
	require('../../config/verification.php');
?>

<html>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>Exporter les projets</title>

    <link rel="icon" type="image/png" href="../../assets/icon.png" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Polices CSS -->
    <link rel="stylesheet" href="../../css/fonts.css">

		<!-- Default CSS -->
    <link rel="stylesheet" href="../../css/default.css">

		<!-- exportProjects CSS -->
    <link rel="stylesheet" href="css/exportprojects.css">

    <!-- Fullpage form CSS -->
    <link rel="stylesheet" href="../../css/fullpage-form.css">

		<!-- exportProjects functions -->
		<script src="js/exportProjects.js"></script>

	</head>
	<body>
		<a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

		<h1>Exporter la liste des Projets</h1>

    <form method="post" action="#" id="_main-form" name="form">

      <!-- Select -->
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-sort"></i></div>
          <select class="form-control" id="_convert">
            <option value="1" default>Exporter en CSV</option>
            <option value="2">Exporter en JSON</option>
          </select>
        </div>
      </div>

      <!-- Select -->
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-sort"></i></div>
          <select class="form-control" id="_group">
            <option value="0" default>Tous les projets</option>
          </select>
        </div>
      </div>

      <!-- Valid Button -->
      <div class="form-group no-border form-button submit-button">
        <button type="submit">
          <span>Télécharger</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
        </button>
      </div>
    </form>
	</body>
</html>
