
$(window).load(function() {

  $(".bouton").click(function() {
    importFromLDAP();
  });

});

/* Fonction d'import */
function importFromLDAP() {
  /* On exécute le script qui récupère les utilisateurs LDAP et qui les passe dans la BD */
  $.ajax({
    url : './php/importUsers.php',
    dataType : 'json',
    success : function(data) {
      //On vérifie qu'il n'y a pas eu d'erreur
      if (data.error == 0) {
        /* On affiche le nombre d'utilisateurs importés */
        if ( data.nbImport == 0 ) {
          $(".container").append("<span><i>Aucun utilisateur à importer</i>");
        } else if ( data.nbImport == 1 ) {
          $(".container").append("<span>Import de 1 utilisateur");
        } else {
          $(".container").append("<span>Import de " + data.nbImport + " utilisateurs");
        }
      }
      //Sinon on affiche le message d'erreur
      else {
        alert(data.error);
      }
    },
    error : function(xhr) {
      alert(xhr.error);
    }
  });
}
