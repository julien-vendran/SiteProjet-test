$(window).ready(function() {
  //nom();
  $("#mailto_list").change();

  $("#listMail").on('click',".list", function(event){
    var mail = $(this);
    $("#mail_object").val(mail.children(".object").html());
    $("#mail_content").val(mail.children(".content").html());
  });

  $("#mailto_list").on("change", function (event) {
    $('#listMail').empty();
    $("#mail_object").val("");
    $("#mail_content").val("");
    data = {
      'niveau': this.value,
    };
    getMail(data);
  });

  // Fonction d'envoi du mail
  $('#form').submit(function (evt) { // cett function bloque l'envoie du formulaire.
    evt.preventDefault();
  });
  $("button[type='submit']").click(function (e) { // nous allons vérifier si tous les champs sont remplis avant d'envoyer le mail, sinon on affiche un message d'erreur
    if ($("#mail_object").val().length != 0 && $("#mail_content").val().length != 0 && $("#mailto_list").val().length !=0 ) {
      e.preventDefault();
      var $this = $('#load');
      $this.button('loading');
      setTimeout(function () {
        $this.button('reset');
        sendMail();
        alert("Email envoyé");
        document.location.href = '../..';
      }, 2000);
    }
    else {
      $("#alertMessage").css("display","block");
    }
  });
});

// function nom (){
//     $.ajax({
//       url : 'php/getGroups.php',
//       dataType : 'json',
//       success : function(text) {
//         if(text.error != 0) {
//           // en cas d'erreur
//         }
//
//         $.each(text.groups, function(index, val) {
//           $("#mailto_list").append("<option value=" + val.promotion + ">"+ val.promotion +"</option>");
//         });
//       },
//       error : function(xhr) {
//         //alert("Une erreur est survenue lors de la récupération des groupes correspondants");
//       }
//     });
//
// }(jQuery);



function getMail (promotion){
  $.ajax({
    url : 'php/getMails.php',
    type : 'POST',
    data : promotion,
    dataType : 'json',
    success : function(text) {
      if(text.error != 0) {
        // en cas d'erreur
      }

      $.each(text.emails, function(index, val) {
          $("#listMail").append("<li class='list'>" + val.objet + "<span class=\"object\">" + val.objet + " </span><span class='content'> " + val.mail + "</span></li>");

      });
    },
    error : function(xhr) {
      //alert("Une erreur est survenue lors de la récupération des groupes correspondants");
    }
  });

}(jQuery);

// Fonction qui génére la requête pour envoyer les mails
function sendMail() {
  // On récupère les personnes à qui est destiné le mail
  var cibleNiveau = $("#mailto_list").val();
  // On récupère le message et l'objet
  var objet = $("#mail_object").val();
  var message = $("#mail_content").val();

  $.ajax({
    url : './php/envoiMessage.php',
    type : 'post',
    data : 'niveau=' + cibleNiveau + '&objet=' + objet + '&corps=' + message,
    dataType : 'json',
    success : function(data) {
      if (data.error == 0) {

      } else {
        alert(data.error);
      }
    },
    error : function(xhr) {
      alert("Une erreur s'est produite sur l'envoi des mails");
    }
  });
}
