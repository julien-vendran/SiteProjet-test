<?php
  require('../../config/verification.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Importer les affectations</title>

    <link rel="icon" type="image/png" href="../../assets/icon.png" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Dropzone JS -->
    <script src="js/dropzone.js" charset="utf-8"></script>

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Polices CSS -->
    <link rel="stylesheet" href="../../css/fonts.css">

		<!-- Default CSS -->
    <link rel="stylesheet" href="../../css/default.css">

		<!-- importAffectations CSS -->
    <link rel="stylesheet" href="css/importaffectations.css">

    <!-- Fullpage form CSS -->
    <link rel="stylesheet" href="../../css/fullpage-form.css">

		<!-- importAffectations functions -->
		<script src="js/importAffectations.js"></script>

	</head>
	<body>
		<a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

		<h1>Importer la liste des Affectations</h1>

		<section id="dropzone">
            <div class="text">
                Vous pouvez importer un ou plusieurs fichiers txt en cliquant ici.<br/>
                Vous pouvez également déposer le fichier directement sur cette fenêtre.
            </div>
        </section>

    <form method="POST" action="#" class="container">
  		<div class="loader">
        <div class="fa fa-cog fa-spin"></div>
        Recherche d'affectations
      </div>

      <!-- Valid Button -->
      <div class="form-group no-border form-button submit-button close">
        <button type="submit">
          <span>Importer</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
        </button>
      </div>

      <div class="results">
      </div>

      <ul class="affectations-list">
      </ul>
    </form>
	</body>
</html>
