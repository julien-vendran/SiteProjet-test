
$(window).load(function() {

  initialise();
  miseAJour();

  $(".heure").not(".sp").children(".count").mouseenter(function() {
    if( $(this).text() != 0 ) {
      $(this).css({"cursor" : "pointer"});
      $(this).animate({"color" : "#FF5660"}, 300);
    }
  }).mouseout(function() {
    if( $(this).text() != 0 ) {
      $(this).css({"cursor" : "pointer"});
      $(this).animate({"color" : "#000"}, 300);
    }
  });

  $(".heure").not(".sp").click(function() {
    if ( $(this).children("div.count").text() != 0 ) {
      $("#masque").fadeIn();
      var taille = $(this).children("div.count").text() * 30 + 20;
      $(this).children(".tuteursCreneau").css({"height" : taille+"px"});
      $(this).children(".tuteursCreneau").fadeIn();
    }
  });

  $("#masque").click(function() {
    $(this).fadeOut();
    $(".heure").children(".tuteursCreneau").fadeOut();
  });

});

function initialise() {
  $(".heure").not(".sp").children("div.count").text(0);
}

function miseAJour() {
  $.ajax({
    type : 'post',
    dataType : 'json',
    url : './php/getCreneaux.php',
    success : function(data) {
      for (var t = 0; t < data.length; t++) {
        var tuteur = data[t];
        var tuteurDispo = JSON.parse(data[t].dispo);

        for (var i = 0; i < tuteurDispo.length; i++) {

          var dispoDuJour = tuteurDispo[i];
          //On détermine quel jour on traite
          switch (i) {
            case 0:
              var jour = "#lundi";
              break;

            case 1:
              var jour = "#mardi";
              break;

            case 2:
              var jour = "#mercredi";
              break;

            case 3:
              var jour = "#jeudi";
              break;

            case 4:
              var jour = "#vendredi";
              break;
          }

          for (var c = 0; c < dispoDuJour.length; c++) {
            var dispoDuCreneau = dispoDuJour[c];
            var creneau = ".c" + (c+1);
            var horaire = $(jour).children(creneau);
            if (dispoDuCreneau == 1) {
              horaire.children("div.count").text( parseInt(horaire.children("div.count").text()) + 1);
              horaire.children("div.tuteursCreneau").append("<li>" + tuteur.nom + "</li>");
            }
          }//Fin du for qui traite les créneaux du jour actuel

        }//Fin du for pour les disponibilité du tuteur actuel

      }//Fin du for pour la liste des tuteurs
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });
}
