$(window).load(function () {
  // on rempli le select de sélection du groupe
  $('#_main-form #_group').getGroups();

  $('#_main-form').on('submit', function() {
    var form = $(this);
    form.generate();
    return false;
  });
});

// fonction getGroups
// fonction implémentée à jQuery (utilisation $(selector).getGroups())
// à utiliser sur un objet de type select
// rempli le select avec les groupes existant dans la base de données
(function($) {
  $.fn.getGroups = function() {
    var select = $(this);
    
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
            select.append("<option value="+val.promotion+">Les voeux des "+val.promotion+"</option>");
          });
        }
      },
      // sinon, on signale une erreur
      error : function(xhr) {
        console.log("error : error while trying to get groups list");
      }
    });
  }
})(jQuery);

// fonction generate
// fonction implémentée à jQuery (utilisation $(selector).generate())
// à utiliser sur un objet de type formulaire
// désactive les champs du formulaire et traite l'envoi du formulaire en ajax
(function($) {
  $.fn.generate = function() {
    var form = $(this);

    // on désactive le formulaire
    form.disableForm();

    // on active le chargement du boutton
    form.find('div.submit-button').children('button').addClass('load');

    // on récupère le type vers lequel convertir la liste de projets avec
    //   1 : csv
    //   2 : json
    var convert = $("#_convert").val();

    // on récupère le groupe pour lequel récupérer les projets
    var group = $("#_group").val();

    
    $.ajax({
      url : "php/generate.php",
      type : 'POST',
      // on envoi le type vers lequel convertir la liste des projets et le groupe
      data : "convert="+convert+"&group="+group,
      // on s'attend à récupérer des données structurées en json
      dataType : 'json',
      // si la réception s'effectue sans problèmes, on redirige l'utilisateur vers le menu
      success : function(text) {
        if(text.error == 0) {
          console.log(text);
          setTimeout(function() {
            form.find('div.submit-button').children('button').addClass('ok');

            // si le script a bien retourné une url, on redirige l'utilisateur
            if (text.url != "") window.location = text.url;
          }, 500);
        }
      },
      // sinon, on réactive le formulaire et on signale une erreur
      error : function(xhr) {
        form.find('div.submit-button').children('button').removeClass('load');
        form.enableForm();

        console.log("error : error while trying to generate the wishes list file");
      }
    });
  }
})(jQuery);

// fonction enableForm
// fonction implémentée à jQuery (utilisation $(selector).enableForm())
// à utiliser sur un objet de type formulaire
// active les champs du formulaire et annule l'envoi basique du formulaire
// à l'envoi, exécute la fonction connect
(function($) {
  $.fn.enableForm = function() {
    this.unbind("submit");
    this.submit(function() {
      $(this).generate();
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
