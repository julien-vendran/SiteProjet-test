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
	<h1>Editer Email</h1>
    <form method="post" action="index.php">
        <!-- Input Select -->
      <div class="form-group row">
        <div class="input-group col s6">
          <div class="input-group-addon"><i class="fa fa-sort"></i></div>
          <select class="form-control" id="mailto_list" name="option">
            <option value="0">Toute la promotion</option>
            <option value="1">A1</option>
            <option value="2">A2</option>
            <option value="3">As</option>
            <option value="4">Licence</option>
            <option value="5">Enseignant</option>
          </select>
        </div>
        <!-- Valid Button -->
        <div class="form-group no-border form-button submit-button col s6">
            <button type="submit">
                <span>Rechercher</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
            </button>
        </div>
      </div>

    </form>
    <div class="container row">
        <div class="col s12">
        <ul class="collection with-header">
            <li class="collection-header">
                <h4 class="left-align">Liste des emails</h4>
            </li>
            <?php
                require 'ModelEmail.php';
                if(empty($_POST['option'])){//on regarde si la variable existe
                    $tab = ModelEmail::getAllEmail();
                }
                else{
                    switch ($_POST['option']) {
                        case 0:
                            $tab = ModelEmail::getAllEmail();
                        break;
                        case 1:
                            $tab = ModelEmail::getEmailWithPromotion('A1');
                        break;
                        case 2:
                            $tab = ModelEmail::getEmailWithPromotion('A2');
                        break;
                        case 3:
                            $tab = ModelEmail::getEmailWithPromotion('As');
                        break;
                        case 4:
                            $tab = ModelEmail::getEmailWithPromotion('Licence');
                        break;
                        case 5:
                            $tab = ModelEmail::getEmailWithPromotion('Enseignant');
                        break;
                    }
                    
                }
                foreach ($tab as $e)
                        echo '<li class="collection-item"><div><p><span  class="red-text">'.htmlspecialchars($e->getPromotion()).'</span>   '.htmlspecialchars($e->getObjet()).'</p>   '.htmlspecialchars($e->getEmail()).'<a href="editEmail.php?email='.rawurlencode($e->getEmail()).'&promo='.rawurlencode($e->getPromotion()).'&id='.rawurlencode($e->getIdEmail()).'&obj='.rawurlencode($e->getObjet()).'" class="secondary-content"><i class="material-icons black-text">create</i></a></div></li>';
            ?>
        </ul>
        </div>
        <a class="waves-effect waves-light btn-large red lighten-1" href="create.php"><i class="material-icons left">add</i>Créer Email</a>
    </div>

</body>
</html>