<?php
require('../../config/verification.php');
require '../../config/DB.php';
require './php/nbProject.php';
//print_r ($_SESSION);
//echo "level=".$_SESSION["level"][0]

?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Liste des projets</title>

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

    <!-- sendMail CSS -->
    <link rel="stylesheet" href="css/projectList.css">

    <!-- Fullpage form CSS -->
    <link rel="stylesheet" href="../../css/fullpage-form.css">

    <!-- projectList Script -->
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
                    <h2></h2>
                </div>
            </div>
            <div class="modal-body text-center">
                <p class="desc"></p>
                <p class="site"></p>
                <p class="bd"></p>
                <p class="interface"></p>
                <p class="algo"></p>
                <p class="reseaux"></p>
                <p class="rem"></p>
                <ul class="tuteurs"></ul>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

<h1>Liste des projets</h1>
<?php
$v= nbProject::nbprojActif();
$da = nbProject::nbprojActifDeuxiemeAnnee();
$li = nbProject::nbprojActifLicence();
$as = nbProject::nbprojActifAnneeSpeciale();
$ina = nbProject::nbprojInactif();
$dai = nbProject::nbprojInactifDeuxiemeAnne();
$lii = nbProject::nbprojInactifLicence();
$asi = nbProject::nbprojInactifAnneeSpeciale();
$all = nbProject::nbprojTotal();
if (($_SESSION["level"][0] == 4) || ($_SESSION["level"][0] == 3)) {
    echo <<< EOT

                <div class="center">
                    <div class="btn-group">

                            <form id="formfilterPromo" method="post" action="">
                                <select id="promo" name="promo" class="browser-default custom-select custom-select-lg mb-3">
                                      <option disabled selected >Promotion</option>
                                      <option value="A2">Deuxieme année</option>
                                      <option value="Licence">Licence</option>
                                      <option value="As">Année spéciale</option>
                                </select>
                                
                                <select id="activite" name="activite" class="browser-default custom-select custom-select-lg mb-3" style="display: none">
                                      <option disabled selected value="5">Activité</option>
                                      <option  value="1">Actif</option>
                                      <option value="0">Inactif</option>
                                </select>
                            </form>
                                
                </div>
EOT;
}
?>

<div class="container projects load">
    <div class="loader">
        <div class="fa fa-cog fa-spin"></div>
        Chargement des projets
    </div>
</div>
<script src="js/filtre.js"></script>
</body>

</html>
