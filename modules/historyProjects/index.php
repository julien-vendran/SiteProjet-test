<?php
require('../../config/verification.php');
require '../../config/DB.php';
//print_r ($_SESSION);
//echo "level=".$_SESSION["level"][0]

?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Historique des projets</title>

    <link rel="icon" type="image/png" href="../../assets/icon.png" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Polices CSS -->
    <link rel="stylesheet" href="../../css/fonts.css">

    <!-- Default CSS -->
    <link rel="stylesheet" href="../../css/default.css">

    <link rel="stylesheet" href="css/projectList.css">



    <!-- Fullpage form CSS -->
    <link rel="stylesheet" href="../../css/fullpage-form.css">
    <script src="js/projectList.js"></script>


</head>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">


<body>

<!-- Modal d'informations du projet -->
<div class="modal fade" id="_infos-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
                <div class="modal-title text-center">
                    <h4></h4>
                </div>
            </div>
            <div class="modal-body text-center">
                <p class="desc"></p>
                <p class="rem"></p>
                <p class="niveau"></p>
                <ul class="date"></ul>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

<h1>Historique des projets</h1>

<div class="container projects load">
    <div class="loader">
        <div class="fa fa-cog fa-spin"></div>
        Chargement des projets
    </div>
</div>
</body>

</html>
