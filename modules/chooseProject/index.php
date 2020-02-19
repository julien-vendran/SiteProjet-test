<?php
  require('../../config/verification.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>Choix et classement des projets</title>

    <link rel="icon" type="image/png" href="../../assets/icon.png" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

    <!-- Jquery UI -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>


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

    <!-- Css Choix des voeux -->
    <link rel="stylesheet" href="css/style.css">

    <!-- ChooseProject js  -->
    <script type="text/javascript" src="js/chooseProject.js"></script>

  </head>
  <body>
    <a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

    <h1>Choix et classement des projets : </h1>

    <form method="POST">

      <div class="row">
        <div class="col-xs-6">
          <h1>Projets: </h1>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-search"></i></div>
              <input type="text" name="search" id="searchInput" placeholder="Rechercher" class="form-control"/>
            </div>
          </div>
          <div class="form-group" id="projectList">
          </div>
        </div>

        <div class="col-xs-6">
          <h1>Voeux: </h1>
          <div class="form-group" id="wishList">
          </div>
        </div>
      </div>


      <!-- Valid Button -->
      <div class="form-group no-border form-button submit-button">
        <button type="submit">
          <span>Enregistrer</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
        </button>
      </div>

    </form>
  </body>
</html>
