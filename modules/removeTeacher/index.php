<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Supprimer un prof</title>
	<link rel="icon" type="image/png" href="../../assets/icon.png" />
	<!-- Jquery -->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Polices CSS -->
    <link rel="stylesheet" href="../../css/fonts.css">
    <link rel="stylesheet" href="css/removeTeacher.css">

		<!-- Default CSS -->
    <link rel="stylesheet" href="../../css/default.css">
    <!-- Fullpage form CSS -->
    <link rel="stylesheet" href="../../css/fullpage-form.css">
    <!-- Materialize: Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
	<a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>
	<h1>Liste des professeurs</h1>
    <div  class="container load">
        <ul class="collection">
        <?php
            require 'ModelProf.php';
            $tab_p = ModelProf::getAllProf();
            foreach ($tab_p as $p)
                echo  '<li class="collection-item"><div class="grey-text text-darken-2">'.$p->getLogin().'<a href="removeProf.php?login='.$p->getLogin().'" class="secondary-content"><i class="material-icons red-text">clear</i></a></div></li>';
        ?>
        </ul>
    </div>

</body>
</html>