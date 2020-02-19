<?php
  require('../../config/verification.php');
?>

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

    <!-- contactTutor functions -->
    <script src="js/contactTutor.js"></script>
    <title>Contacter son tuteur</title>

    <link rel="icon" type="image/png" href="../../assets/icon.png" />
  </head>
  <body>
    <a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

    <h1>Envoyer un mail à son tuteur</h1>

    <form method="post" action="mailToTutor.php" id="contactTutor_form">

      <!-- Input Object -->
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-sign-out"></i></div>
          <input type="text" class="form-control disabled" id="mail_tuteur" disabled>
          <div class="input-group-addon"><i class="fa fa-close"></i></div>
        </div>
      </div>

      <!-- Input Object -->
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
          <input type="text" class="form-control" id="mail_object" placeholder="Objet">
          <div class="input-group-addon"><i class="fa fa-close"></i></div>
        </div>
      </div>

      <!-- Textarea -->
      <div class="form-group">
        <div class="input-group-addon"><i class="fa fa-plus-square-o"></i></div>
        <textarea class="form-control" id="mail_content" placeholder="Contenu du mail"></textarea>
      </div>

      <!-- Valid Button -->
      <div class="form-group no-border form-button submit-button">
        <button type="submit">
          <span>Envoyer</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
        </button>
      </div>
    </form>
  </body>
</html>