$(window).load(function() {
  $('#contactTutor_form').enableForm();

  $.ajax({
    url : "php/getTutor.php",
    type : 'POST',
    // on s'attend à récupérer des données structurées en json
    dataType : 'json',
    // si la réception s'effectue sans problèmes, on redirige l'utilisateur vers le menu
    success : function(text) {
      if(text.error == 0) {
        $("#mail_tuteur").val(text.mail);
      } else {
        console.log("error : no tutor for current user");

        alert("Aucun tuteur associé");
        document.location.href = '../..';
      }
    },
    error : function() {
      console.log("error : error while trying to get tutor for current user");

      alert("Erreur lors de la récupération du tuteur");
      document.location.href = '../..';
    }
  });
});

function sendMail() {
  var object = $("#mail_object").val();
  var content = $("#mail_content").val();

  $('#contactTutor_form').children('.submit-button').children('button:not(.load)').addClass('load');
  $('#contactTutor_form').disableForm();

  setTimeout(function() {
    if($.isEmptyObject(content)) {
      $('.submit-button').children('button.load').removeClass('load');
      $('#contactTutor_form').enableForm();
      alert("veuillez remplir les champs");
    } else {
      $.ajax({
        url : "php/mailToTutor.php",
        type : 'POST',
        // on envoi l'identifiant de la session PHP et la demande de sauvegarde du cookie en POST
        data : "mail_object="+object+"&mail_content="+content,
        // on s'attend à récupérer des données structurées en json
        dataType : 'json',
        // si la réception s'effectue sans problèmes, on redirige l'utilisateur vers le menu
        success : function(text) {
          if(text.error == 0) {
            setTimeout(function() {
              $('.submit-button').children('button.load:not(.ok)').addClass('ok');
            }, 500);
            alert("Votre email a été envoyé");
            setTimeout(function(){
              window.location.replace("../../menu.php");
            }, 500);
          }
        },
        error : function(xhr) {
          $('.submit-button').children('button.load').removeClass('load');
          $('#contactTutor_form').enableForm();

          console.log("error : error while trying to send a mail");
        }
      });
    }
  }, 500);
}



// fonction enableForm
// fonction implémentée à jQuery (utilisation $(selector).enableForm())
// à utiliser sur un objet de type formulaire
// active les champs du formulaire et annule l'envoi basique du formulaire
// à l'envoi, exécute la fonction connect
(function($) {
  $.fn.enableForm = function() {
    this.unbind("submit");
    this.submit(function() {
      sendMail();
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
