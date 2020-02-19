
$(window).load(function() {

  // On charge les tuteurs
  setTimeout(function() {
    $(".load i").removeClass("fa-spin fa-cog").addClass("fa-check");
    $(".load").fadeOut(500, function() {
      $(".load").remove();
    });
    loadTuteurs();
  }, 1000);

  $("#masque").click(function() {
    $(this).fadeOut(400);
  });

  // Fonction de recherche
  $("input[name='search']").keyup(function() {
    // On récupère la valeur pour générer le filtre
    var filtre = $(this).val();
    filtre = filtre.toLowerCase();
    // Pour chaque tuteur, on vérifie si le filtre le concerne
    $(".tuteur").each(function() {
      // On récupère les informations du module
      var login = $(this).attr("id");
      login = login.toLowerCase();
      var nom = $(this).text();
      nom = nom.toLowerCase();
      // Si la recherche correspond, on affiche le tuteur
      // Sinon, on le masque
      if ( login.includes(filtre) || nom.includes(filtre) ) {
        $(this).fadeIn();
      } else {
        $(this).fadeOut();
      }
    });
  });

});

// Fonction de chargement des tuteurs
function loadTuteurs() {
  $.ajax({
    url : './php/getTuteurs.php',
    dataType : 'json',
    success : function(data) {
      if (data.error == 0) {
        for (var i = 0; i < data.tuteurs.length; i++) {
          var tuteur = data.tuteurs[i];
          $(".tuteurs").append("<span class='tuteur' id=" + tuteur.login + ">" + tuteur.prenom + " " + tuteur.nom);
        }
        // Fonction d'affichage des disponibilités
        $(".tuteur").click(function() {
          if ( !($("#masque").is(":visible")) ) {
            loading( $(this).attr("id") );
            $("#masque").fadeIn(400);
          }
        });
      } else {
        alert(data.error);
      }
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });
}


// Affecte le planning avec les disponibilités de l'enseignant passés en paramètre
function loading(uid) {
  $.ajax({
    type : 'POST',
    url : "php/getPlanningTuteur.php",
    data : {id : uid},
    dataType : 'json',
    success : function(retour) {
      var data = JSON.parse(retour.disp);
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
    },
    error : function(xhr) {
      alert("Erreur : " + xhr.responseText);
    }
  });
}

function clearPlanning() {
  for (var i = 0; i < 5; i++) {
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
    for (var j = 0; j < 9; j++) {
      heure = '.c';
      heure += j+1;
      horaire = $(jour).children(heure).children('span');
      horaire.attr("class", "fa fa-question idk");
    }
  }
}
