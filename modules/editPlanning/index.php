<?php
  require('../../config/verification.php');
?>

<html>
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Editer le planning</title>

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

	<!-- editPlanning CSS -->
	<link rel="stylesheet" href="css/editPlanning.css">

	</head>
    <body>

      <!-- Modal de création de l'évènement -->
      <div class="modal fade" id="_new-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
              <div class="modal-title text-center">
                <h2>Nouvel évènement</h2>
              </div>
            </div>
            <div class="modal-body text-center">
              <form method="post" action="#" id="form-event">

                <div class="datepicker"></div>

                <!-- Select -->
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-sort"></i></div>
                    <select class="form-control _for">
                      <option value="0" default>Pour toute les promotions</option>
                    </select>
                  </div>
                </div>

                <!-- Input Object -->
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-header"></i></div>
                    <input type="text" class="form-control _title" placeholder="Titre" required>
                    <div class="input-group-addon"><i class="fa fa-close"></i></div>
                  </div>
                </div>

                <!-- Textarea -->
                <div class="form-group">
                  <div class="input-group-addon"><i class="fa fa-plus-square-o"></i></div>
                  <textarea class="form-control _description" placeholder="Description"></textarea>
                </div>

                <!-- Valid Button -->
                <div class="form-group no-border form-button submit-button">
                  <button type="submit">
                    <span>Ajouter</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
                  </button>
                </div>

              </form>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->





      <!-- Modal de modification de l'évènement -->
      <div class="modal fade" id="_edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
              <div class="modal-title text-center">
                <h2>Modifier l'évènement</h2>
                <h4>Titre de l'évènement</h4>
              </div>
            </div>
            <div class="modal-body text-center">
              <form method="post" action="#" id="form-event">

                <div class="datepicker"></div>

                <input type="hidden" id="_event-id">

                <!-- Select -->
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-sort"></i></div>
                    <select class="form-control _for">
                      <option value="0" default>Pour toute les promotions</option>
                    </select>
                  </div>
                </div>

                <!-- Input Object -->
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-header"></i></div>
                    <input type="text" class="form-control _title" placeholder="Titre" required>
                    <div class="input-group-addon"><i class="fa fa-close"></i></div>
                  </div>
                </div>

                <!-- Textarea -->
                <div class="form-group">
                  <div class="input-group-addon"><i class="fa fa-plus-square-o"></i></div>
                  <textarea class="form-control _description" placeholder="Description"></textarea>
                </div>

                <!-- Valid Button -->
                <div class="form-group no-border form-button submit-button">
                  <button type="submit">
                    <span>Enregistrer</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
                  </button>
                </div>

                <!-- Valid Button -->
                <div class="form-group no-border form-button delete-button">
                  <button onclick="$('#_edit-modal form').delEvent();return false;">
                    <span>Supprimer</span><span><i class="fa fa-cog fa-spin"></i></span><span><i class="fa fa-check"></i></span>
                  </button>
                </div>

              </form>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <a href="../../" class="return"><i class="fa fa-angle-left"></i> Retour</a>

      <h1>Planning</h1>

      <a href="#" class="new" onclick="$('#_new-modal').initModal( function() { $('#_new-modal form').saveEvent(); } );return false;"><img src="icon/plus_math.png" alt="new" /></a>

      <ol id="planning">
      </ol>

      <script type="text/javascript" src="js/editPlanning.js"></script>
    </body>
</html>
