<?php
  require('../../config/verification.php');
?>

<html>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Editer un projet</title>

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

		<!-- sendMail CSS -->
    <link rel="stylesheet" href="css/projectList.css">

    <!-- Fullpage form CSS -->
    <link rel="stylesheet" href="../../css/fullpage-form.css">

		<!-- projectList Script -->
		<script src="js/projectList.js"></script>

	</head>
	<body>

    <!-- Modal d'informations du projet -->
    <div class="modal fade" id="_infos-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
            <div class="modal-title text-center">
              <h2></h2>
            </div>
          </div>
          <div class="modal-body text-center">
            <p class="desc"></p>
              <p class="site"></p>
              <p class="bd"></p>
              <p class="interface"></p>
              <p class="algo"></p>
              <p class="reseaux"></p>
            <p class="rem"></p>
            <div class="options">
              <span class="modify">Modifier</span>
              <span class="delete">Supprimer</span>
            </div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

		<a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

		<h1>Liste des projets</h1>

		<div class="container projects load">
      <div class="loader">
        <div class="fa fa-cog fa-spin"></div>
        Chargement des projets
      </div>
		</div>
	</body>
</html>
