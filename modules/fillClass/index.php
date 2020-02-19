<?php
  require('../../config/verification.php');
?>

<html>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Renseigner sa classe</title>

    <link rel="icon" type="image/png" href="../../assets/icon.png" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  	<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

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
    <link rel="stylesheet" href="../../css/fonts.css">

		<!-- Default CSS -->
    <link rel="stylesheet" href="../../css/default.css">

    <!-- Fullpage form CSS -->
    <link rel="stylesheet" href="../../css/fullpage-form.css">

		<!-- editProject CSS -->
		<link rel="stylesheet" href="css/fillClass.css">

	</head>
	<body>

		<a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

		<h1>Renseigner sa classe</h1>

    <div class="container">
      <!-- Modal de la classe -->
      <div class="modal fade" id="class-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
              <div class="modal-title text-center">
                <h2 class="name">Classe</h2>
              </div>
            </div>
            <div class="modal-body text-center">
              <ul class="userlist">
              </ul>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <form action="#" method="post" id="tuto" onsubmit="return false;">
        Vous pouvez rechercher un étudiant grâce à la barre de recherche.<br/>
        Il vous suffit ensuite de cliquer sur celui-ci ou de le glisser dans la classe pour l'y ajouter.<br/>
        Vous pouvez également éditer la classe en cliquant dessus.
      </form>

      <form action="#" method="post" id="group" onclick="$('#class-modal').modal('show');" onsubmit="return false;">
        <img src="icon/class.png" alt="classe" />
        <span class="name">Classe</span>
        <span class="info">Cliquez pour éditer</span>
        <span class="nb">0</span>
        <span class="loader"><i class="fa fa-cog fa-spin"></i></span>
      </form>

      <form action="#" method="post" id="searchform" onsubmit="return false;">
        <!-- Input Object -->
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-search"></i></div>
            <input type="text" class="form-control" id="searchbar" placeholder="Rechercher un étudiant" autocomplete="off">
            <div class="input-group-addon"><i class="fa fa-close"></i></div>
          </div>
        </div>

        <ul class="userlist">
        </ul>
      </form>
    </div>

		<script type="text/javascript" src="js/fillClass.js"></script>

	</body>
</html>
