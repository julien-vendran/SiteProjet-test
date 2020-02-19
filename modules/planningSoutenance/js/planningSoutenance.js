
$(window).load(function() {

  loading();

  // Fonction pour choisir le statut de l'heure : non-renseigné, disponible ou absent
  $(".heure > span").click(function() {
    if ( $(this).hasClass("idk") ) {
      $(this).switchClass("idk", "dispo", 300);
      $(this).switchClass("fa-question", "fa-check", 300);
    }
    else if ( $(this).hasClass("dispo") ) {
      $(this).switchClass("dispo", "abs", 300);
      $(this).switchClass("fa-check", "fa-times", 300);
    }
    else if ( $(this).hasClass("abs") ) {
      $(this).switchClass("abs", "idk", 300);
      $(this).switchClass("fa-times", "fa-question", 300);
    }
  });

  $("#check").click(function() {
    save();
  });

});

/* --- FONCTION EN DEHORS DE L'EXECUTION AUTOMATIQUE --- */
function getData() {
  var jours = ["lundi", "mardi", "mercredi", "jeudi", "vendredi"];
  var jourCourant;
  var data = [];
  for (var i = 0; i < jours.length; i++) {
    jourCourant = $("#" + jours[i]);
    data[i] = getDispo(jourCourant);
  }
  return data;
}

function getDispo(jour) {
  var buff = [];
  for (var i = 1; i < 10; i++) {
    buff[i-1] = getCreneau(jour.children(".c" + i));
  }
  return buff;
}

// Pour un créneau donné, renvoi -1, 0 ou 1 respectivement pour l'absence d'information, l'absence ou la disponibilité de l'enseignant pour ce créneau
function getCreneau(cren) {
  return cren.children().hasClass("idk") ? -1 : cren.children().hasClass("abs") ? 0 : 1;
}

// Fonction de sauvegarde des données de l'enseignant
function save() {
  var data = JSON.stringify(getData());
  $.ajax({
    type : 'POST',
    url : "php/saveDispo.php",
    data : {disponibilites : data },
    dataType : 'json',
    success : function(text) {
      alert("Vos disponibilités ont été enregistrées");
    },
    error: function(xhr) {
      alert("Erreur : " + xhr.responseText);
    }
  });
}

// Fonction de chargement des données
function loading() {
  $.ajax({
    type : 'POST',
    url : "./php/getDispo.php",
    dataType : 'json',
    success : function(retour) {
      if (retour == 0) {
        alert("Merci de renseigner vos disponibilités");
      }
      else {
        var data = JSON.parse(retour[0].disp);
        var jour;
        var horaire;
        var heure;
        //On traite les données récupérées
        for (var i = 0; i < data.length; i++) {
          switch (i) {
            case 0: //Lundi
              jour = "#lundi";
              break;

            case 1: //Mardi
              jour = "#mardi";
              break;

            case 2: //Mercredi
              jour = "#mercredi";
              break;

            case 3: //Jeudi
              jour = "#jeudi";
              break;

            case 4: //Vendredi
              jour = "#vendredi";
              break;
          }

          for (var j = 0; j < data[0].length; j++) {
            heure = '.c';
            heure += j+1;
            horaire = $(jour).children(heure).children('span');
            switch (data[i][j]) {
              case 1:
                horaire.switchClass("idk", "dispo");
                horaire.switchClass("fa-question", "fa-check");
                break;
              case 0:
                horaire.switchClass("idk", "abs");
                horaire.switchClass("fa-question", "fa-times");
              break;
              default:
                break;
            }
          }
        }
      }
    },
    error : function(xhr) {
      alert("Erreur : " + xhr.responseText);
    }
  });
}
