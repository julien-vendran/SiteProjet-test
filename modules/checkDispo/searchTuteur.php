<html>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

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

		<!-- editProject CSS -->
		<link rel="stylesheet" href="css/checkDispo.css";>

	</head>
	<body>

		<a href="index.php" class="return"><i class="fa fa-angle-left"></i> Retour</a>

		<h1>Choisir un tuteur pour voir ses disponibilités</h1>

    <div id="masque">
      <div class="semaine">

    		<div class="horaires">
    			<div class="nom">Crénaux</div>
    			<div class="heure sp">8h - 9h</div>
    			<div class="heure sp">9h - 10h</div>
    			<div class="heure sp">10h - 11h</div>
    			<div class="heure sp">11h - 12h</div>
    			<div class="heure sp">12h - 13h</div>
    			<div class="heure sp">13h - 14h</div>
    			<div class="heure sp">14h - 15h</div>
    			<div class="heure sp">16h - 17h</div>
    			<div class="heure sp">17h - 18h</div>
    		</div>

  			<div class="jour" id="lundi">
  				<div class="nom">Lundi</div>
  				<div class="heure c1"><span class="fa fa-question idk"></span></div>
  				<div class="heure c2"><span class="fa fa-question idk"></span></div>
  				<div class="heure c3"><span class="fa fa-question idk"></span></div>
  				<div class="heure c4"><span class="fa fa-question idk"></span></div>
  				<div class="heure c5"><span class="fa fa-question idk"></span></div>
  				<div class="heure c6"><span class="fa fa-question idk"></span></div>
  				<div class="heure c7"><span class="fa fa-question idk"></span></div>
  				<div class="heure c8"><span class="fa fa-question idk"></span></div>
  				<div class="heure c9"><span class="fa fa-question idk"></span></div>
  			</div>

  			<div class="jour" id="mardi">
  				<div class="nom">Mardi</div>
  				<div class="heure c1"><span class="fa fa-question idk"></span></div>
  				<div class="heure c2"><span class="fa fa-question idk"></span></div>
  				<div class="heure c3"><span class="fa fa-question idk"></span></div>
  				<div class="heure c4"><span class="fa fa-question idk"></span></div>
  				<div class="heure c5"><span class="fa fa-question idk"></span></div>
  				<div class="heure c6"><span class="fa fa-question idk"></span></div>
  				<div class="heure c7"><span class="fa fa-question idk"></span></div>
  				<div class="heure c8"><span class="fa fa-question idk"></span></div>
  				<div class="heure c9"><span class="fa fa-question idk"></span></div>
  			</div>

  			<div class="jour" id="mercredi">
  				<div class="nom">Mercredi</div>
  				<div class="heure c1"><span class="fa fa-question idk"></span></div>
  				<div class="heure c2"><span class="fa fa-question idk"></span></div>
  				<div class="heure c3"><span class="fa fa-question idk"></span></div>
  				<div class="heure c4"><span class="fa fa-question idk"></span></div>
  				<div class="heure c5"><span class="fa fa-question idk"></span></div>
  				<div class="heure c6"><span class="fa fa-question idk"></span></div>
  				<div class="heure c7"><span class="fa fa-question idk"></span></div>
  				<div class="heure c8"><span class="fa fa-question idk"></span></div>
  				<div class="heure c9"><span class="fa fa-question idk"></span></div>
  			</div>

  			<div class="jour" id="jeudi">
  				<div class="nom">Jeudi</div>
  				<div class="heure c1"><span class="fa fa-question idk"></span></div>
  				<div class="heure c2"><span class="fa fa-question idk"></span></div>
  				<div class="heure c3"><span class="fa fa-question idk"></span></div>
  				<div class="heure c4"><span class="fa fa-question idk"></span></div>
  				<div class="heure c5"><span class="fa fa-question idk"></span></div>
  				<div class="heure c6"><span class="fa fa-question idk"></span></div>
  				<div class="heure c7"><span class="fa fa-question idk"></span></div>
  				<div class="heure c8"><span class="fa fa-question idk"></span></div>
  				<div class="heure c9"><span class="fa fa-question idk"></span></div>
  			</div>

  			<div class="jour" id="vendredi">
  				<div class="nom">Vendredi</div>
  				<div class="heure c1"><span class="fa fa-question idk"></span></div>
  				<div class="heure c2"><span class="fa fa-question idk"></span></div>
  				<div class="heure c3"><span class="fa fa-question idk"></span></div>
  				<div class="heure c4"><span class="fa fa-question idk"></span></div>
  				<div class="heure c5"><span class="fa fa-question idk"></span></div>
  				<div class="heure c6"><span class="fa fa-question idk"></span></div>
  				<div class="heure c7"><span class="fa fa-question idk"></span></div>
  				<div class="heure c8"><span class="fa fa-question idk"></span></div>
  				<div class="heure c9"><span class="fa fa-question idk"></span></div>
  			</div>
  		</div>
    </div>

		<!-- Affichage de la page par défaut -->
		<div class="container">
			<!-- Fonction de recherche -->
			<form>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-search"></i></div>
						<input class="form-control" type="text" name="search" placeholder="Recherche...">
					</div>
				</div>
			</form>

			<div class="tuteurs">
				<span class="load"><i class="fa fa-cog fa-spin"></i>Chargement...</span>
			</div>
		</div>



		<script type="text/javascript" src="js/searchTuteur.js"></script>

	</body>
</html>
