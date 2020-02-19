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
    <link rel="stylesheet" href="../../../css/fonts.css">

		<!-- Default CSS -->
    <link rel="stylesheet" href="../../../css/default.css">

		<!-- addProject CSS -->
    <link rel="stylesheet" href="css/addproject.css">

    <!-- Fullpage form CSS -->
    <link rel="stylesheet" href="../../../css/fullpage-form.css">

		<!-- addProject functions -->
    <script src="js/addProject.js"></script>

	</head>
	<body>
		<?php
			/*

			MODULE addProject
			permet à un tuteur de créer un nouveau projet

			*/

		?>

		<a href="../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

		<h1>Modifier un projet</h1>

		<form id="editProject_form" name="form">
			<!-- Input Object -->
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-header"></i></div>
					<input type="text" class="form-control" id="project_title" placeholder="Titre" required>
					<div class="input-group-addon"><i class="fa fa-close"></i></div>
				</div>
			</div>

			<!-- Select -->
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-sort"></i></div>
					<select class="form-control" id="project_annee">
					</select>
				</div>
			</div>

			<!-- Textarea -->
			<div class="form-group">
				<textarea class="form-control" id="project_description" placeholder="Description du projet" required></textarea>
			</div>

			<!-- Textarea -->
			<div class="form-group">
				<div class="input-group-addon"><i class="fa fa-plus-square-o"></i></div>
				<textarea class="form-control" id="project_more" placeholder="Remarques"></textarea>
			</div>

			<!-- Select -->
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-sort"></i></div>
					<select class="form-control" id="project_cotuteur">
						<option value="">Aucun co-tuteur</option>
					</select>
				</div>
			</div>

            <h3>Specification du projet</h3>
            <!-- <div class="form-check" id="project_site">
                <input class="form-check-input" type="checkbox" id="sql" name="project_site">
                <label class="form-check-label" for="inlineCheckbox1">Site web dynamique (ex : PHP/NodeJs)</label>
            </div> -->
            <div class="form-check" >
                <input class="form-check-input" type="checkbox" name="project_site" id="project_site">
                <label class="form-check-label" for="inlineCheckbox1">Site web dynamique (ex : PHP/NodeJs)</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="project_bd" name="project_bd">
                <label class="form-check-label" for="inlineCheckbox2">Présence d'une base de données</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="project_interface" name="project_interface">
                <label class="form-check-label" for="inlineCheckbox3">Interface graphique client lourd (ex : JavaFX)</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="project_algo" name="project_algo">
                <label class="form-check-label" for="inlineCheckbox3">Algorithmique avancé: algorithme de graphe, de jeux (ex: min/max)</label>
            </div>
            <div class="form-check" >
                <input class="form-check-input" type="checkbox" id="project_reseaux" name="project_reseaux">
                <label class="form-check-label" for="inlineCheckbox3">Réseaux (ex : mise en oeuvre de sockets)</label>
            </div>


			<!-- Activate checkbox -->
      <div class="checkbox" id="project_actif">
        <span class="character-checkbox"></span>
        <span class="label">Projet Actif</span>
      </div>

			<!-- Valid Button -->
      <div class="form-group no-border form-button submit-button">
        <button type="submit" class="modif">
          <span>Modifier</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
        </button>
      </div>
      <div class="form-group no-border form-button submit-button">
        <button type="submit" class="duplicate">
       <span>Dupliquer</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
        </button>
    </div>
		</form>
	</body>
</html>
