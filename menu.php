<?php
  // on vérifie que l'utilisateur est connecté. Dans le cas contraire, on le renvoie sur la page de connexion
  session_start();
    //$_SESSION["uid"] = "projets";
    //$_SESSION["level"] = 4;
  if(!isset($_SESSION["uid"]) || empty($_SESSION["uid"])) header('Location:index.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Gestion de Projets</title>

    <link rel="icon" type="image/png" href="assets/icon.png" />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

    <!-- Jquery UI -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <?php
    // on vérifie si l'utilisateur utilise une surface tactile
    if(preg_match('/iphone/i',$_SERVER['HTTP_USER_AGENT']) || preg_match('/android/i',$_SERVER['HTTP_USER_AGENT']) || preg_match('/blackberry/i',$_SERVER['HTTP_USER_AGENT']) || preg_match('/symb/i',$_SERVER['HTTP_USER_AGENT']) || preg_match('/ipad/i',$_SERVER['HTTP_USER_AGENT']) || preg_match('/phone/i',$_SERVER['HTTP_USER_AGENT'])) {
    ?>

    <!-- Jquery UI for Mobile -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

    <?php
    }
    ?>

    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Polices CSS -->
    <link rel="stylesheet" href="css/fonts.css">

    <!-- Default CSS -->
    <link rel="stylesheet" href="css/default.css">

    <!-- Modules CSS -->
    <link rel="stylesheet" href="css/modules.css">

    <!-- Deconnect functions -->
    <script type="text/javascript" src="js/deconnect.js"></script>

    <!-- Modules functions -->
    <script type="text/javascript" src="js/modules.js"></script>

    <!-- Initialisation functions -->
    <script type="text/javascript" src="js/init-menu.js"></script>

    <!-- Research functions -->
    <script type="text/javascript" src="js/search.js"></script>
  </head>
  <body>
    <header>
      <img src="assets/logo_um.png" alt="Logo UM" class="img-left" />
      <img src="assets/logo_iut.jpg" alt="Logo IUT" class="img-right" />
      
      <div class="title">
        <h1>Gestion de Projets</h1>
        <h3>Departement Informatique</h3>
      </div>

      <div class="menu-opener" onclick="$(this).toggleClass('open');$('.menu.menu-right').toggleClass('open');">
        <i class="fa fa-bars"></i>
      </div>
    </header>

    <nav class="container modules load">
      <div class="loader">
        <div class="fa fa-cog fa-spin"></div>
        Chargement des modules
      </div>

      <ul class="content">
      </ul>
    </nav>

    <nav class="container searchbox load">
      <a href="#" class="close" aria-label="close" onclick="$('nav.searchbox').toggleClass('open');$('nav.searchbox').toggleClass('load');$('nav.modules').toggleClass('dismis');">&times;</a>

      <div class="loader">
        <div class="fa fa-cog fa-spin"></div>
        Recherche en cours</div>
      </div>

      <div class="empty">
        <div class="fa fa-info"></div>
        Aucun résultat pour votre recherche
      </div>

      <div class="content">
      </div>
    </nav>

    <ul class="menu menu-right">
      <li class="user_id">anonyme</li>
      <li class="deconnect">déconnexion</li>

      <!-- Search Input -->
      <li class="form-group">
        <div class="input-group">
          <input type="text" class="form-control" id="search_input" placeholder="rechercher">
          <div class="input-group-addon"><i class="fa fa-search"></i></div>
        </div>
      </li>

      <li class="title"><a href="modules/showPlanning">PROCHAINE ÉTAPE</a></li>

      <li class="next-event"></li>

      <!--<li class="title">MENU</li>
      <li><i class="fa fa-user"></i> Menu 1<i class="fa fa-caret-right"></i></li>
      <li><i class="fa fa-close"></i> Menu 2<i class="fa fa-caret-right"></i></li>
      <li><i class="fa fa-search"></i> Menu 3<i class="fa fa-caret-right"></i></li>
      <li><i class="fa fa-lock"></i> Menu 4<i class="fa fa-caret-right"></i></li>-->
    </ul>
  </body>
</html>
