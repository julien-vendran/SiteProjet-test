<?php
  require('../../config/verification.php');
?>

<html>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Afficher le planning</title>

    <link rel="icon" type="image/png" href="../../assets/icon.png" />

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

	<!-- showPlanning CSS -->
	<link rel="stylesheet" href="css/showPlanning.css";>

	</head>
	<body>

    <!-- Modal de menu du planning -->
    <div class="modal fade" id="_export-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
            <div class="modal-title text-center">
              <h2>Exporter le planning</h2>
            </div>
          </div>
          <div class="modal-body text-center">
            <ul>
              <li><a href="../../abonnement.php?u=<?= $_SESSION['uid']?>"><span class="title">Télécharger le planning</span> <img src="icon/download.png" alt="download" /> Exportez le calendrier au format ics, vous pourrez l'importer dans une application tierce.</a></li>
              <li onclick="$('#_tuto-modal').modal('show');"><span class="title">S'abonner au planning</span> <img src="icon/rss.png" alt="rss" /> Le lien généré vous permettra de vous abonner au planning. Votre calendrier se mettra donc automatiquement à jour depuis une application tierce.</li>
            </ul>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal de menu de l'abonnement au planning -->
    <div class="modal fade" id="_tuto-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
            <div class="modal-title text-center">
              <h2>Abonnement au planning</h2>
            </div>
          </div>
          <div class="modal-body text-center">
            <a href="../../abonnement.php?u=<?= $_SESSION['uid']?>" style="display:block;margin-bottom:10px">../../abonnement.php?u=<?= $_SESSION['uid']?></a>
            <ul>
              <li onclick="$('#_tuto-ios-modal').modal('show');"><span class="title">iOS</span> <img src="icon/ios.png" alt="ios" /> Vous trouverez quelque explications pour ajouter l'abonnement au planning sur iPhone.</li>
              <li onclick="$('#_tuto-android-modal').modal('show');"><span class="title">Android</span> <img src="icon/android.png" alt="android" />  Vous trouverez quelque explications pour ajouter l'abonnement au planning sur Android.</li>
            </ul>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal de tuto de l'abonnement au planning sur ios -->
    <div class="modal fade tuto" id="_tuto-ios-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
            <div class="modal-title text-center">
              <h2>Abonnement au planning sur iPhone</h2>
            </div>
          </div>
          <div class="modal-body text-center">
            <ol>
              <li><span class="desc">Allez dans Réglages, "Mail, Contacts, Calendrier". </span><img src="images/ios/1.png" alt="" /></li>
              <li><span class="desc">Touchez "Ajouter un compte". </span><img src="images/ios/2.png" alt="" /></li>
              <li><span class="desc">Choisissez "Autre". </span><img src="images/ios/3.png" alt="" /></li>
              <li><span class="desc">Touchez "Ajouter un cal. avec abonnement". </span><img src="images/ios/4.png" alt="" /></li>
              <li><span class="desc">Entrez l'adresse du serveur : <a href="../../abonnement.php?u=<?= $_SESSION['uid']?>">../../abonnement.php?u=<?= $_SESSION['uid']?></a> et validez. </span><img src="images/ios/5.png" alt="" /></li>
            </ol>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal de tuto de l'abonnement au planning sur android -->
    <div class="modal fade tuto" id="_tuto-android-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
            <div class="modal-title text-center">
              <h2>Abonnement au planning sur iPhone</h2>
            </div>
          </div>
          <div class="modal-body text-center">
            <ol>
              <li><span class="desc">Allez sur <a href='https://calendar.google.com/calendar/'>google agenda</a> sur navigateur. </span><img src="images/android/1.png" alt="" /></li>
              <li><span class="desc">Cliquez sur la petite flèche à droite de 'Autres Agendas' puis sur 'Ajouter par URL'. </span><img src="images/android/2.png" alt="" /></li>
              <li><span class="desc">Entrez l'url du serveur (<a href="../../abonnement.php?u=<?= $_SESSION['uid']?>">../../abonnement.php?u=<?= $_SESSION['uid']?></a>) dans le champs URL puis cliquez sur ajouter  </span><img src="images/android/3.png" alt="" /></li>
              <li><span class="desc">Votre agenda est importé. </span><img src="images/android/4.png" alt="" /></li>
              <li><span class="desc">Allez désormais sur l'application 'Agenda' de votre mobile Android. </span><img src="images/android/5.png" alt="" /></li>
              <li><span class="desc">Puis rendez vous dans les paramètres (menu de gauche->paramètres) et appuyez sur plus d'agenda en dessous du compte gmail sur lequel vous venez d'importer l'agenda </span><img src="images/android/6.png" alt="" /></li>
              <li><span class="desc">L'agenda importé devrait s'afficher. Appuyez sur cet agenda.</span><img src="images/android/7.png" alt="" /></li>
              <li><span class="desc">Appuyez ensuite sur le bouton à droite de synchronisation pour qu'il soit bleu comme ci-dessous. </span><img src="images/android/8.png" alt="" /></li>
              <li><span class="desc">Votre agenda est désormais synchronisé sur votre portable ! </span><img src="images/android/9.png" alt="" /></li>
            </ol>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



	  <a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

	  <h1>Planning</h1>

      <a href="#" class="download" onclick="$('#_export-modal').modal('show');return false;"><img src="icon/external.png" alt="download" /></a>

      <ol id="planning">
      </ol>

	  <script type="text/javascript" src="js/showPlanning.js"></script>
	</body>
</html>
