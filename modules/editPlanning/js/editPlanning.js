
$(window).load(function() {

  // On charge le planning déjà enregistré
  loadPlanning();

  // On charges les promotions pour l'ajout d'évènement
  loadGroups();

  $(".datepicker").datepicker({
    firstDay: 1,
    monthNames: [ "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre" ]
  });
});







// Fonction permettant de charger les dates déjà enregistrées
function loadPlanning() {

  $.ajax({
    url : "php/getPlanning.php",
    type : 'GET',
    data : "",
    // on s'attend à récupérer des données structurées en json
    dataType : 'json',
    // si la réception s'effectue sans problèmes
    success : function(text) {
      if(text.error == 0) {
        var events = [];
        // on créé le tableau des évènements en fonction des mois ...
        $.each(text.planning, function (index, value) {
          var infos = {
            "id" : value.id,
            "y" : value.date.y,
            "d" : value.date.d,
            "h" : value.date.h,
            "mn" : value.date.mn,
            "w" : value.date.w,
            "title" : value.title,
            "desc" : value.desc,
            "promo" : value.name
          };

          if(parseInt(value.date.m) >= 9) var id = parseInt(value.date.m) - 8;
          else var id = parseInt(value.date.m) + 4;

          if(events[id] == null) events[id] = [infos];
          else events[id].push(infos);
        });

        // on affiche le planning
        showPlanning(events);

        return true;
      }
    },
    // sinon, on signale une erreur
    error : function(xhr) {
      console.log("error : error while trying to get planning");
    }
  });
}







function showPlanning(events) {
  // on récupère la date actuelle
  var now = new Date();

  if(now.getMonth >= 8) var year = parseInt(now.getFullYear());
  else var year = parseInt(now.getFullYear() - 1);

  $.each(events, function (index, value) {
    // si il y a un évènement dans le mois ...
    if(value != null) {
      // on ajoute le tableau qui contiendra les évènements du mois ...
      switch(index) {

        case 1:
          $("#planning").append("<li><ul id='container-1'><li class='title'>Septembre " + year + "</li></ul></li>");
          break;

        case 2:
          $("#planning").append("<li><ul id='container-2'><li class='title'>Octobre " + year + "</li></ul></li>");
          break;

        case 3:
          $("#planning").append("<li><ul id='container-3'><li class='title'>Novembre " + year + "</li></ul></li>");
          break;

        case 4:
          $("#planning").append("<li><ul id='container-4'><li class='title'>Décembre " + year + "</li></ul></li>");
          break;

        case 5:
          $("#planning").append("<li><ul id='container-5'><li class='title'>Janvier " + (year+1) + "</li></ul></li>");
          break;

        case 6:
          $("#planning").append("<li><ul id='container-6'><li class='title'>Février " + (year+1) + "</li></ul></li>");
          break;

        case 7:
          $("#planning").append("<li><ul id='container-7'><li class='title'>Mars " + (year+1) + "</li></ul></li>");
          break;

        case 8:
          $("#planning").append("<li><ul id='container-8'><li class='title'>Avril " + (year+1) + "</li></ul></li>");
          break;

        case 9:
          $("#planning").append("<li><ul id='container-9'><li class='title'>Mai " + (year+1) + "</li></ul></li>");
          break;

        case 10:
          $("#planning").append("<li><ul id='container-10'><li class='title'>Juin " + (year+1) + "</li></ul></li>");
          break;

        case 11:
          $("#planning").append("<li><ul id='container-11'><li class='title'>Juillet " + (year+1) + "</li></ul></li>");
          break;

        case 12:
          $("#planning").append("<li><ul id='container-12'><li class='title'>Aout " + (year+1) + "</li></ul></li>");
          break;
      }

      // on rempli le tableau avec les évènements
      $.each(value, function (index2, value2) {

        // on créé le conteneur du jour ...
        switch(parseInt(value2.w)) {
          case 0:
            var day = "<span class='day'><span class='w'>dim</span><span class='d'>"+value2.d+"</span></span>";
            break;

          case 1:
            var day = "<span class='day'><span class='w'>lun</span><span class='d'>"+value2.d+"</span></span>";
            break;

          case 2:
            var day = "<span class='day'><span class='w'>mar</span><span class='d'>"+value2.d+"</span></span>";
            break;

          case 3:
            var day = "<span class='day'><span class='w'>mer</span><span class='d'>"+value2.d+"</span></span>";
            break;

          case 4:
            var day = "<span class='day'><span class='w'>jeu</span><span class='d'>"+value2.d+"</span></span>";
            break;

          case 5:
            var day = "<span class='day'><span class='w'>ven</span><span class='d'>"+value2.d+"</span></span>";
            break;

          case 6:
            var day = "<span class='day'><span class='w'>sam</span><span class='d'>"+value2.d+"</span></span>";
            break;
        }

        // on créé le conteneur de la promo
        promo = "<span class='promo'>Pour "+value2.promo+"</span>";

        // on créé le conteneur du titre ...
        var title = "<span class='title'>"+value2.title+"</span>";

        // on créé le conteneur de la description ...
        var desc = "<span class='desc'>"+value2.desc+"</span>";

        // enfin, on assemble l'évènement
        $("#planning #container-" + index).append("<li id='"+value2.id+"'>"+day+title+promo+desc+"</li>");
      });
    }
  });

  $("#planning ul > li:not(.title)").on( "click", function () {
    $(this).editModal();
  });
}







function loadGroups() {
  var select = $("._for");

  $.ajax({
    url : "php/getGroups.php",
    type : 'GET',
    data : "",
    // on s'attend à récupérer des données structurées en json
    dataType : 'json',
    // si la réception s'effectue sans problèmes, on rempli le select
    success : function(text) {
      if(text.error == 0) {
        $.each(text.groups, function (id, val) {
          select.append("<option value='"+val.id+"'>Pour les "+val.name+"</option>");
        });
      }
    },
    // sinon, on signale une erreur
    error : function(xhr) {
      console.log("error : error while trying to get groups list");
    }
  });
}







// fonction enableForm
// fonction implémentée à jQuery (utilisation $(selector).enableForm())
// à utiliser sur un objet de type formulaire
// active les champs du formulaire et annule l'envoi basique du formulaire
// à l'envoi, exécute la fonction connect
(function($) {
  $.fn.enableForm = function( callback ) {
    this.unbind("submit");
    this.submit(function() {
      callback();
      return false;
    });
    this.children('.form-group').children('.input-group').children('input:not(.disabled)').prop('disabled', false);
    this.children('.form-group').children('.input-group').children('select:not(.disabled)').prop('disabled', false);
    this.children('.form-group').children('textarea:not(.disabled)').prop('disabled', false);
    this.children('.checkbox:not(.disabled)').click(function() {
      $(this).toggleClass('show');
    });
    this.children('.checkbox.disabled').removeClass("disabled");
  }
})(jQuery);


// fonction disableForm
// fonction implémentée à jQuery (utilisation $(selector).disableForm())
// à utiliser sur un objet de type formulaire
// désactive les champs du formulaire et annule l'envoi basique du formulaire ET l'envoi ajax du formulaire
(function($) {
  $.fn.disableForm = function() {
    this.unbind("submit");
    this.submit(function() {
      return false;
    });
    this.children('.form-group').children('.input-group').children('input').prop('disabled', true);
    this.children('.form-group').children('.input-group').children('select').prop('disabled', true);
    this.children('.form-group').children('textarea').prop('disabled', true);
    this.children('.checkbox').unbind("click");
    this.children('.checkbox').addClass("disabled");
  }
})(jQuery);








// fonction initModal
// fonction implémentée à jQuery (utilisation $(selector).initModal())
// à utiliser sur un objet de type modal bootstrap
// vide le modal et réinitialise la date sélectionnée
(function($) {
  $.fn.initModal = function( callback ) {
    // on enregistre le conteneur du modal
    var modal = $(this);

    // on récupère la date actuelle
    var now = new Date();
    var date = (now.getMonth()+1)+"/"+now.getDate()+"/"+now.getFullYear();

    // on place le sélecteur de date à aujourd'hui
    modal.find('.datepicker').datepicker( "setDate", date );

    // on vide tous les inputs et les textarea
    modal.find('input').val("");
    modal.find('textarea').val("");

    // on réinitialise les select
    modal.find('select').prop('selectedIndex', 0);

    // on annule tous les chargements du boutton d'envoi
    modal.find('button.load').removeClass('load');
    modal.find('button.ok').removeClass('ok');

    // si ce n'est pas fait, on réactive le formulaire
    modal.find('form').enableForm( callback );

    modal.modal( 'show' );
  }
})(jQuery);








// fonction editModal
// fonction implémentée à jQuery (utilisation $(selector).editModal())
// à utiliser sur un objet de type li, contenant un évènement
// ouvre le modal de modification de l'évènement, avec les bons paramètres
(function($) {
  $.fn.editModal = function() {
    // on enregistre le conteneur de l'évènement
    var evt = $(this);

    // on enregistre le modal de modification
    var modal = $("#_edit-modal");

    // on enregistre le formulaire concerné
    var form = modal.find('form');

    // on enregistre l'id de l'évènement à modifier
    var id_evt = evt.attr('id');

    // on vide le modal et on l'ouvre
    modal.initModal( function() { $('#_edit-modal form').editEvent(); } );

    // on défini les paramètres
    var params = {
      id : id_evt
    }

    // on récupère les informations du modal
    $.ajax({
      url : "php/getEvent.php",
      type : 'POST',
      // on envoi le tableau des paramètres en POST
      data : params,
      // on s'attend à récupérer des données structurées en json
      dataType : 'json',
      // si la réception s'effectue sans problèmes ...
      success : function(text) {

        // si le script PHP ne renvoie pas d'erreur
        if(text.error == 0) {

          // on rempli les champs de texte du formulaire avec les infos récupérées ...

          // l'id de l'évènement ...
          form.find("#_event-id").val(id_evt);

          // le select de la promotion ...
          form.find('._for option[value="0"]').prop('selected', true);
          form.find('._for option[value="'+text.event.idPromo+'"]').prop('selected', true);

          // le titre ...
          form.find('._title').val(text.event.title);
          modal.find(".modal-title h4").text(text.event.title);

          // la description ...
          form.find('._description').val(text.event.description);

          // la date ...
          var date = text.event.month+"/"+text.event.day+"/"+text.event.year;
          form.find('.datepicker').datepicker( "setDate", date );

          return true;
        }

      },
      error : function(xhr) {

        setTimeout(function () {

          modal.modal( 'hide' );

        }, 500);

        console.log("error : error while trying to get the event");
      }

    });
  }
})(jQuery);












// fonction saveEvent
// fonction implémentée à jQuery (utilisation $(selector).saveEvent())
// à utiliser sur un objet de type formulaire
// désactive les champs du formulaire et enregistre l'évènement actuel
(function($) {
  $.fn.saveEvent = function() {

    var form = $(this);

    // on désactive le formulaire
    form.disableForm();

    // on signale à l'utilisateur le chargement
    form.children('.submit-button').children('button:not(.load)').addClass('load');

    var promoId = parseInt(form.find("._for").val());

    if(promoId == 0){
      var params = {
        date : {
          day : form.find('.datepicker').datepicker( "getDate" ).getDate(),
          month : form.find('.datepicker').datepicker( "getDate" ).getMonth() + 1,
          year : form.find('.datepicker').datepicker( "getDate" ).getFullYear()
        },
        title : form.find("._title").val(),
        desc : form.find("._description").val(),
        valid : true
      };
    }
    else {
      // on récupère les paramètres de l'évènement
      var params = {
        date : {
          day : form.find('.datepicker').datepicker( "getDate" ).getDate(),
          month : form.find('.datepicker').datepicker( "getDate" ).getMonth() + 1,
          year : form.find('.datepicker').datepicker( "getDate" ).getFullYear()
        },
        promo : promoId,
        title : form.find("._title").val(),
        desc : form.find("._description").val(),
        valid : true
      };
    }

    // on vérifie la validité des paramètres ...
    if(params.date == null || params.promo < 0 || params.title == "" || params.desc == "") params.valid = false;

    // si le formulaire n'a pas été rempli correctement, on réactive le formulaire et on annule l'envoi
    if(!params.valid) {
      setTimeout(function () {

        // on signale à l'utilisateur l'arret du chargement
        form.children('.submit-button').children('button.load').removeClass('load');

        // on réactive le formulaire
        form.enableForm( function() { form.saveEvent(); } );

      }, 500);

      return false;
    }

    // sinon, on envoie une requête ajax pour enregistrer l'évènement
    $.ajax({
      url : "php/saveEvent.php",
      type : 'POST',
      // on envoi le tableau des paramètres en POST
      data : params,
      // on s'attend à récupérer des données structurées en json
      dataType : 'json',
      // si la réception s'effectue sans problèmes ...
      success : function(text) {

        // si le script PHP ne renvoie pas d'erreur
        if(text.error == 0) {

          setTimeout(function () {

            // on recharge le planning
            $("#planning").html("");
            loadPlanning();

            // on signale à l'utilisateur l'arret du chargement
            form.children('.submit-button').children('button.load').addClass('ok');

            setTimeout( function () {

              // on ferme le modal de création
              $("#_new-modal").modal( 'hide' );

            }, 500);

          }, 500);

          return true;
        } else {
          alert(text.error);
          setTimeout(function () {

            // on signale à l'utilisateur l'arret du chargement
            form.children('.submit-button').children('button.load').removeClass('load');

            // on réactive le formulaire
            form.enableForm( function() { form.saveEvent(); } );

          }, 500);

          console.log("error : error while trying to save the event");

        }

      },
      error : function(xhr) {

        setTimeout(function () {

          // on signale à l'utilisateur l'arret du chargement
          form.children('.submit-button').children('button.load').removeClass('load');

          // on réactive le formulaire
          form.enableForm( function() { form.saveEvent(); } );

        }, 500);
        alert(error);
        console.log("error : error while trying to save the event");
      }

    });
  }
})(jQuery);












// fonction editEvent
// fonction implémentée à jQuery (utilisation $(selector).editEvent())
// à utiliser sur un objet de type formulaire
// désactive les champs du formulaire et enregistre l'évènement actuel
(function($) {
  $.fn.editEvent = function() {

    var form = $(this);

    // on désactive le formulaire
    form.disableForm();

    // on signale à l'utilisateur le chargement
    form.children('.submit-button').children('button:not(.load)').addClass('load');

    // on récupère les paramètres de l'évènement
    var params = {
      date : {
        day : form.find('.datepicker').datepicker( "getDate" ).getDate(),
        month : form.find('.datepicker').datepicker( "getDate" ).getMonth() + 1,
        year : form.find('.datepicker').datepicker( "getDate" ).getFullYear()
      },
      promo : parseInt(form.find("._for").val()),
      title : form.find("._title").val(),
      desc : form.find("._description").val(),
      id : parseInt(form.find("#_event-id").val()),
      valid : true
    };

    // on vérifie la validité des paramètres ...
    if(params.date == null || params.promo < 0 || params.title == "" || params.desc == "" || params.id == null || params.id < 0) params.valid = false;

    // si le formulaire n'a pas été rempli correctement, on réactive le formulaire et on annule l'envoi
    if(!params.valid) {
      setTimeout(function () {

        // on signale à l'utilisateur l'arret du chargement
        form.children('.submit-button').children('button.load').removeClass('load');

        // on réactive le formulaire
        form.enableForm( function() { form.editEvent(); } );

      }, 500);

      return false;
    }

    // sinon, on envoie une requête ajax pour enregistrer l'évènement
    $.ajax({
      url : "php/editEvent.php",
      type : 'POST',
      // on envoi le tableau des paramètres en POST
      data : params,
      // on s'attend à récupérer des données structurées en json
      dataType : 'json',
      // si la réception s'effectue sans problèmes ...
      success : function(text) {

        // si le script PHP ne renvoie pas d'erreur
        if(text.error == 0) {

          setTimeout(function () {

            // on recharge le planning
            $("#planning").html("");
            loadPlanning();

            // on signale à l'utilisateur l'arret du chargement
            form.children('.submit-button').children('button.load').addClass('ok');

            setTimeout( function () {

              // on ferme le modal de création
              $("#_edit-modal").modal( 'hide' );

            }, 500);

          }, 500);

          return true;
        } else {
          alert(text.error);
          setTimeout(function () {

            // on signale à l'utilisateur l'arret du chargement
            form.children('.submit-button').children('button.load').removeClass('load');

            // on réactive le formulaire
            form.enableForm( function() { form.editEvent(); } );

          }, 500);

          console.log("error : error while trying to update the event");

        }

      },
      error : function(xhr) {

        setTimeout(function () {

          // on signale à l'utilisateur l'arret du chargement
          form.children('.submit-button').children('button.load').removeClass('load');

          // on réactive le formulaire
          form.enableForm( function() { form.editEvent(); } );

        }, 500);

        console.log("error : error while trying to update the event");

      }

    });
  }
})(jQuery);











// fonction delEvent
// fonction implémentée à jQuery (utilisation $(selector).editEvent())
// à utiliser sur un objet de type formulaire
// désactive les champs du formulaire et supprime l'évènement actuel
(function($) {
  $.fn.delEvent = function() {

    var form = $(this);

    // on désactive le formulaire
    form.disableForm();

    // on signale à l'utilisateur le chargement
    form.children('.delete-button').children('button:not(.load)').addClass('load');

    // on récupère les paramètres de l'évènement
    var params = {
      id : parseInt(form.find("#_event-id").val()),
      valid : true
    };

    // on vérifie la validité des paramètres ...
    if(params.id == null || params.id < 0) params.valid = false;

    // si le formulaire n'a pas été rempli correctement, on réactive le formulaire et on annule l'envoi
    if(!params.valid) {
      setTimeout(function () {

        // on signale à l'utilisateur l'arret du chargement
        form.children('.delete-button').children('button.load').removeClass('load');

        // on réactive le formulaire
        form.enableForm( function() { form.editEvent(); } );

      }, 500);

      return false;
    }

    // sinon, on envoie une requête ajax pour supprimer l'évènement
    $.ajax({
      url : "php/delEvent.php",
      type : 'POST',
      // on envoi le tableau des paramètres en POST
      data : params,
      // on s'attend à récupérer des données structurées en json
      dataType : 'json',
      // si la réception s'effectue sans problèmes ...
      success : function(text) {

        // si le script PHP ne renvoie pas d'erreur
        if(text.error == 0) {

          setTimeout(function () {

            // on recharge le planning
            $("#planning").html("");
            loadPlanning();

            // on signale à l'utilisateur l'arret du chargement
            form.children('.delete-button').children('button.load').addClass('ok');

            setTimeout( function () {

              // on ferme le modal de création
              $("#_edit-modal").modal( 'hide' );

            }, 500);

          }, 500);

          return true;
        } else {

          setTimeout(function () {

            // on signale à l'utilisateur l'arret du chargement
            form.children('.delete-button').children('button.load').removeClass('load');

            // on réactive le formulaire
            form.enableForm( function() { form.editEvent(); } );

          }, 500);

          console.log("error : error while trying to delete the event");
        }

      },
      error : function(xhr) {

        setTimeout(function () {

          // on signale à l'utilisateur l'arret du chargement
          form.children('.delete-button').children('button.load').removeClass('load');

          // on réactive le formulaire
          form.enableForm( function() { form.editEvent(); } );

        }, 500);

        console.log("error : error while trying to delete the event");
      }

    });
  }
})(jQuery);
