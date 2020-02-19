<?php
  require('../../config/verification.php');
?>

<html>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Créer une classe</title>

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

		<!-- chooseDelegues CSS -->
		<link rel="stylesheet" href="css/chooseDelegues.css";>

    <!-- Script JS chooseDelegues -->
    <script type="text/javascript" src="js/chooseDelegues.js"></script>

	</head>
	<body>

		<a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

		<h1>Créer un groupe de TD</h1>

    <form action="#" id="GroupeTD_form">
      <div class="classe">
        <!-- Champ de texte pour le nom du groupe -->
        <div class="form-group" id"choixNom">
          <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-users"></i></div>
            <input type="text" class="form-control" name="inputNom" placeholder="Nom groupe"/>
          </div>
        </div>

        <!--Champ de choix de promotion-->
        <div class="form-group" id="choixPromo">
          <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-sort"></i></div>
            <select class="form-control promoList" id="promoSelect">
              <option value="Promotion" selected="select" disabled id="def">Promotion</option>
            </select>
          </div>
        </div>


        <!--Champ de recherche pour le délégué 1 du groupe-->
        <div class="form-group" id="choixD1">
          <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-user"></i></div>
            <input type="text" class="form-control" name="inputD1" id="inputD1" placeholder="Délégué" autocomplete="off"/>
          </div>
        </div>

        <!--Auto-suggestion de la recherche-->
        <div class="suggest" id="suggestD1">

        </div>

        <!--Champ de recherche pour le délégué 2 du groupe-->
        <div class="form-group" id="choixD2">
          <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-user"></i></div>
            <input type="text" class="form-control" name="inputD2" id="inputD2" placeholder="Délégué 2" autocomplete="off"/>
          </div>
        </div>

        <!--Auto-suggestion de la recherche-->
        <div class="suggest" id="suggestD2">

        </div>
      </div>

      <!-- Ajout de classe Button -->
      <div class="form-group no-border form-button" id="addClass">
        <div class="button-add">
          <span><i class="fa fa-plus"></i>Ajouter une classe</span>
        </div>
      </div>

      <!-- Valid Button -->
      <div class="form-group no-border form-button submit-button" id="valider">
        <button type='submit'>
          <span>Valider</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
        </button>
      </div>

    </form>




	</body>
</html>
