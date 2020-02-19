<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Editer Email</title>
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
	<h1>Créer Email</h1>
        <form method="get" action="created.php">
            <div class="form-group row">
                <div class="form-group col s12">
                    <div class="input-group-addon"><i class="material-icons">edit</i></div>
                    <input type="text" class="form-control" placeholder="objet" name="obj">
                </div>
                <div class="form-group col s12">
                    <div class="input-group-addon"><i class="material-icons">edit</i></div>
                    <textarea class="form-control" placeholder="email" id="mail_content" name="email" required/></textarea> 
                </div>
                <div class="input-group col s6">
                    <div class="input-group-addon"><i class="fa fa-sort"></i></div>
                    <select class="form-control" id="mailto_list" name="promo">
                        <option value="A1">A1</option>
                        <option value="A2">A2</option>
                        <option value="As">As</option>
                        <option value="Licence">Licence</option>
                        <option value="Enseignant">Enseignant</option>
                    </select>
                </div>
                <input type="hidden" class="form-control" name="id" value="'.$_GET['id'].'">
                <div class="form-group no-border form-button submit-button col s6">
                    <button type="submit">
                        <span>Valider</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
                    </button>
                </div>
            </div>
            </from>
</body>
</html>