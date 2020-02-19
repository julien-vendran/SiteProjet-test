<?php
  require('../../config/verification.php');
?>

<html>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Envoyer un mail</title>

    <link rel="icon" type="image/png" href="../../assets/icon.png" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Polices CSS -->
    <link rel="stylesheet" href="../../css/fonts.css">

		<!-- Default CSS -->
    <link rel="stylesheet" href="../../css/default.css">

		<!-- sendMail CSS -->
    <link rel="stylesheet" href="css/sendmail.css">

    <!-- Fullpage form CSS -->
    <link rel="stylesheet" href="../../css/fullpage-form.css">

		<!-- sendMail functions -->


	</head>
	<body>
		<a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

		<h1>Envoyer un mail</h1>
        <div class="alert alert-danger" id="alertMessage" style="display: none;" role="alert"">
            Veuillez compléter tous les champs.
        </div>
		<form method="post" action="" id="form">
			<!-- Input Select -->
      <div class="form-group center">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-sort"></i></div>
          <select class="form-control" id="mailto_list">
              <option disabled selected>Choisir la promotion</option>
              <option value="A1">Première Année</option>
              <option value="A2">Deuxième année</option>
              <option value="Licence">Licence</option>
              <option value="As">Année spéciale</option>
          </select>
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
        <button type="submit" id="load" data-loading-text="<i class='fa fa-cog fa-spin'></i> Envoi..">
          <span>Envoyer</span>
        </button>
      </div>
		</form>

		<nav class="menu-selector">
			<h3>Liste des emails disponibles</h3>

            <ul id="listMail">
                <li>Veuillez selectionner une promotion afin de voir les mails disponibles.</li>
			</ul>
		</nav>
        <script src="js/sendMail.js"></script>
	</body>
</html>
