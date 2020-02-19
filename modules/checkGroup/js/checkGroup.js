
$(window).load(function() {

  // On charge les groupes
  loadGroup();

  // On active la fonction de recherche
  $("input[name='recherche']").keyup(function() {
    recherche( $(this).val().toLowerCase() );
  });

});

/* Fonction de chargement des groupes */
function loadGroup(fonction) {
  $.ajax({
    url : './php/getGroupe.php',
    dataType : 'json',
    success : function(groupes) {
      for (var i = 0; i < groupes.length; i++) {
        var groupe = groupes[i];
        $("form").append("<div class='groupe' id=" + groupe.idGroupe + ">");
        var element = $("#" + groupe.idGroupe);
        element.prepend("<h3>" + groupe.prenom + " " + groupe.nom);
        /* On détermine si le groupe a un projet ou non */
        if (groupe.titre) {
          element.append("<div class='titre'>" + groupe.titre);
        }
        else {
          element.append("<div class='titre'><i>Aucun projet affecté</i>");
        }
        element.append("<ul class='membres'>");
        /* On charge ensuite les membres de ce groupe */
        loadMember(groupe.idGroupe);
      }
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });

  fonction;

}

/* Fonction de chargement des membres d'un groupe */
function loadMember(id) {
  $.ajax({
    url : "./php/getMembers.php",
    type : "post",
    data : "id=" + id,
    dataType : "json",
    success : function(membres) {
      var liste = $("#" + id).children(".membres");
      /* On ajoute chaque membre à la liste des membres de son groupe */
      for (var i = 0; i < membres.length; i++) {
        var membre = membres[i];
        liste.append("<li>" + membre.prenom + " " + membre.nom);
      }
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });
}

// Fonction de recherche
function recherche(filter) {
  // On prépare la casse
  var filtre = filter.toLowerCase();

  $(".groupe").each(function() {
    // On récupère les informations du groupe
    var chefGroupe = $(this).children("h3").text().toLowerCase();
    var projet = $(this).children("div.titre").text().toLowerCase();
    var membres = new Array();
    $(this).children("ul.membres").children("li").each(function() {
      membres.push( $(this).text().toLowerCase() );
    });

    // On initialise un compteur pour la vérification
    var cpt = 0;

    // On effectue les recherches pour trouver les occurences du filtre
    cpt = ( chefGroupe.includes(filtre) ) ? 1 : cpt;
    cpt = ( projet.includes(filtre) ) ? 1 : cpt;
    for (var i = 0; i < membres.length; i++) {
      cpt = ( membres[i].includes(filtre) ) ? 1 : cpt;
    }

    // Enfin, on traite le résultat
    if ( cpt == 1 ) {
      $(this).fadeIn();
    } else {
      $(this).fadeOut();
    }

  });
}
