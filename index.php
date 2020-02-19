<?php
  // on vérifie que l'utilisateur n'est pas connecté. Dans le cas contraire, on le renvoie sur la page principale
  session_start();
  if(isset($_SESSION["uid"]) && !empty($_SESSION["uid"])) header('Location:menu.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Connexion</title>

    <link rel="icon" type="image/png" href="assets/icon.png" />

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
    <link rel="stylesheet" href="css/fonts.css">

    <!-- Default CSS -->
    <link rel="stylesheet" href="css/default.css">

    <!-- Fullpage form CSS -->
    <link rel="stylesheet" href="css/fullpage-form.css">

    <!-- User Auth & LDAP auth functions -->
    <script type="text/javascript" src="js/connect.js"></script>

    <!-- Particles JS -->
    <script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <!-- User Auth & LDAP auth functions -->
    <script type="text/javascript" src="js/init-particles.js"></script>

    <!-- Functions for auto connexion -->
    <script type="text/javascript" src="js/auto-connect.js"></script>
  </head>
  <body id="particles-js">
    <header>
      <a href="http://www.umontpellier.fr"><img src="assets/logo_um.png" alt="Logo UM" /></a>
    </header>

    <form id="connect-form" method="post" action="#" class="form">

      <!-- Input Login -->
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-user"></i></div>
          <input type="text" class="form-control" id="user_login" placeholder="Identifiant">
          <div class="input-group-addon"><i class="fa fa-close"></i></div>
        </div>
      </div>

      <!-- Input Password -->
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-lock"></i></div>
          <input type="password" class="form-control" id="user_password" placeholder="Mot de passe">
          <div class="input-group-addon"><i class="fa fa-close"></i></div>
        </div>
      </div>

      <!-- Remember checkbox -->
      <div class="checkbox">
        <span class="character-checkbox"></span>
        <span class="label">Rester connecté</span>
      </div>

      <!-- Valid Button -->
      <div class="form-group no-border form-button submit-button">
        <button type="submit">
          <span>Connexion</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
        </button>
      </div>
    </form>
  </body>
</html>
