
$(window).load(function() {

  $(".groupes").each(function() {
    $(this).droppable({
      drop : function(event, ui) {
        var tuteur = ui.draggable.attr("data-tuteur");
        var id = ui.draggable.attr("id");
        var nom = ui.draggable.text();

        // On récupère les données du jour de la soutenance
        var year = $(".datepicker").datepicker("getDate").getFullYear();
        var month = $(".datepicker").datepicker("getDate").getMonth() + 1;
        var day = $(".datepicker").datepicker("getDate").getDate();
        // On récupère l'heure
        var heure = $(this).parent().attr("id");
        heure = (heure.length > 2) ? heure.slice(0, -1) : 0 + heure.slice(0, -1);

        saveAffectation(id, day, month, year, heure);
        $("#" + id).remove();
        $(this).append("<span id=" + id + " class='groupe' data-tuteur='" + tuteur + "'>" + nom);
        $(this).children("#" + id).draggable({ helper : "clone" });
      }
    });

    $(".datepicker").datepicker({
      firstDay: 1,
      monthNames: [ "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre" ]
    });

  });

  $("#projets").droppable({
    drop : function(event, ui) {
      var tuteur = ui.draggable.attr("data-tuteur");
      var id = ui.draggable.attr("id");
      var nom = ui.draggable.text();
      var heure = null;
      saveAffectation(id, heure);
      $("#" + id).remove();
      $(this).append("<span id=" + id + " class='groupe' data-tuteur='" + tuteur + "'>" + nom);
      $(this).children("#" + id).draggable({ helper : "clone" });
    }
  });

  loadProjets();

  // On recharge les projets lorsque l'on change de jour
  $("#datepicker").click(function() {
    alert("Click");
    loadProjets();
  });

});

/* Fonction de chargement des projets */
function loadProjets() {
  $.ajax({
    url : "php/getProjet.php",
    dataType : "json",
    success : function(data) {
      // On créer une boucle pour gérer chaque groupe
      for (var i = 0; i < data.length; i++) {
        var groupe = data[i];

        if ( $("#" + groupe.projet).length == 0 ) {
          // Si le groupe n'est pas affiché
          if ( groupe.dateSoutenance == null ) {
            // S'il n'a pas de date, on le met en tant que disponible
            if (groupe.tuteurBis) {
              $("#projets").append("<span id=" + groupe.projet + " class='groupe' data-tuteur='" + groupe.tuteur + "/" + groupe.tuteurBis + "'>" + groupe.titre);
            } else {
              $("#projets").append("<span id=" + groupe.groupe + " class='groupe' data-tuteur='" + groupe.tuteur + "'>" + groupe.titre);
            }

          } else {
            // Sinon c'est que le projet est affecté
            // On récupère la date
            var buffer = groupe.dateSoutenance;
            buffer = buffer.split(" ");
            var date = buffer[0];
            // On créer ensuite la date actuelle au même format
            var year = $(".datepicker").datepicker("getDate").getFullYear();
            var month = ($(".datepicker").datepicker("getDate").getMonth() + 1 > 9) ? $(".datepicker").datepicker("getDate").getMonth() + 1 : "" + $(".datepicker").datepicker("getDate").getMonth() + 1;
            var day = $(".datepicker").datepicker("getDate").getDate();
            var currentDate = year + "-" + month + "-" + day;

            if (currentDate === date) {
              // Si les dates correspondent, alors on récupère l'heure
              var buffHeure = groupe.dateSoutenance;
              buffHeure = buffHeure.split(" ");
              buffHeure = buffHeure[1];
              // On récupère ensuite l'heure uniquement
              buffHeure = buffHeure.split(":");
              var heure = ( buffHeure[0] > 9) ? buffHeure[0] : buffHeure[0][1];

              // On ajoute enfin l'élément là où il doit être
              var horaire = $("#" + heure + "h").children(".groupes");
              if (groupe.tuteurBis) {
                horaire.append("<span id=" + groupe.projet + " class='groupe' data-tuteur='" + groupe.tuteur + "/" + groupe.tuteurBis + "'>" + groupe.titre);
              } else {
                horaire.append("<span id=" + groupe.projet + " class='groupe' data-tuteur='" + groupe.tuteur + "'>" + groupe.titre);
              }
            }
          }

        }
      } // Fin du for

      /* Quand l'ensemble des projets est chargé, on leurs donne la propriété drag & drop */
      $(".groupe").each(function() {
        $(this).draggable({ helper : "clone", scroll : false });
      });
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });
}

/* Fonction de sauvegarde */
function saveAffectation(id, j, m, y, h) {
  $.ajax({
    url : "php/saveProject.php",
    type : 'post',
    data : "id=" + id + "&day=" + j + "&month=" + m + "&year=" + y + "&heure=" + h,
    success : function(data) {
      if (data.error != 0) {
        // alert(data.error);
      }
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });
}

/* Fonction de nettoyage du planning pour le changement de jour */
function clearPlanning() {
  $("tr:not(:first-of-type)").each(function() {
    $(this).children(".groupes").children(".groupe").each(function() {
      $(this).remove();
    });
  });
}
