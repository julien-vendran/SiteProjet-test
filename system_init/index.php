<html>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>Initialisation gestion des projets</title>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  	<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Polices CSS -->
    <link rel="stylesheet" href="../css/fonts.css">

		<!-- Default CSS -->
    <link rel="stylesheet" href="../css/default.css">

    <!-- Fullpage form CSS -->
    <link rel="stylesheet" href="../css/fullpage-form.css">

		<!-- editProject CSS -->
		<link rel="stylesheet" href="css/system_init.css";>

	</head>
	<body>
		<?php
			/*

			MODULE system_init
			Permet à l'administrateur de lancer l'initialisation du système

			*/

			//On charge le fichier de sécurité
			require 'php/security.php';

		?>

		<h1>Initialisation du système</h1>

		<div class="container">

		<?php if( $verif == 0 ) : ?>
			<!-- On s'assure de charge le script JS seulement si c'est nécessaire -->
			<script type="text/javascript" src="js/system_init.js"></script>

			<form class="form" action="initialisation" method="post">
				<!-- Input Login -->
	      <div class="form-group">
	        <div class="input-group">
	          <div class="input-group-addon"><i class="fa fa-user-secret"></i></div>
	          <input type="text" class="form-control" id="admin_login" placeholder="Login LDAP de l'administrateur">
	          <div class="input-group-addon"><i class="fa fa-close"></i></div>
	        </div>
	      </div>

				<!-- Input Nom -->
	      <div class="form-group">
	        <div class="input-group">
	          <div class="input-group-addon"><i class="fa fa-i-cursor"></i></div>
	          <input type="text" class="form-control" id="admin_nom" placeholder="Nom de l'administrateur">
	          <div class="input-group-addon"><i class="fa fa-close"></i></div>
	        </div>
	      </div>

				<!-- Input Prénom -->
	      <div class="form-group">
	        <div class="input-group">
	          <div class="input-group-addon"><i class="fa fa-i-cursor"></i></div>
	          <input type="text" class="form-control" id="admin_prenom" placeholder="Prénom de l'administrateur">
	          <div class="input-group-addon"><i class="fa fa-close"></i></div>
	        </div>
	      </div>

	      <!-- Valid Button -->
				<div id="submit-btn"><span>Lancer</span></div>
			</form>

		<!-- Si la vérification est fausse, le système est déjà initialisé, on redirige l'utilisateur -->
		<?php else : ?>
			<?php header('Location: ..'); ?>
		<?php endif; ?>
		</div>

	</body>
</html>
