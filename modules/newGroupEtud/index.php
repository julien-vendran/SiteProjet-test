<?php
  require('../../config/verification.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

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

    <!-- Fullpage form CSS -->
    <link rel="stylesheet" href="../../css/fullpage-form.css">

    <!-- NewGroup CSS -->
    <link rel = "stylesheet" href="css/newGroupStyle.css">

    <!-- Fonctions d'auto-suggestion-->
    <script src="js/autoSuggest.js"></script>


    <title>Créer groupe</title>

    <link rel="icon" type="image/png" href="../../assets/icon.png" />
  </head>
  <body>
    <a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

    <h1>Créer un nouveau groupe</h1>

    <form method = "GET" id = "newGroup_form" >

	     <!--Champ de recherche pour le chef du groupe-->
      <div class="form-group" id="choixChef">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-user"></i></div>
          <input type="text" class="form-control" id="inputChef" placeholder="Chef du groupe"  autocomplete="off"/>
          <div class="input-group-addon"><i class="fa fa-close"></i></div>
        </div>
      </div>

      <!--Auto-suggestion de la recherche-->
      <div class="suggest" id="suggestChef">

      </div>


      <!--Bloc contenant le chef du groupe-->
      <div id="chefGroupe">

      </div>

      <!--Champ de recherche de membre supplémentaire -->
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-user-plus"></i></div>
          <input type="text" class="form-control" id="inputMembre" placeholder="Membre supplémentaire" autocomplete="off"/>
          <div class="input-group-addon"><i class="fa fa-close"></i></div>
        </div>
      </div>

      <!--Auto-suggestion de la recherche -->
      <div class="suggest" id="suggestMembre">

      </div>


	<!--Bloc contenant les membres sélectionnés-->
      <div id="membresGroupe">

      </div>


      <!-- Valid Button -->
      <div class="form-group no-border form-button submit-button" id="valider">
        <button type="submit">
          <span>Valider</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
        </button>
      </div>

    </form>

  </body>
</html>
