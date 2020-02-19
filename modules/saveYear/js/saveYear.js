
$(window).load(function() {

  getOldSave();

});

/* Fonction permettant de présenter les anciens fichiers de sauvegarde stocké sur le serveur */
function getOldSave() {
  $.ajax({
    url : './php/getOldSave.php',
    dataType : 'json',
    success : function(data) {
      var saves = data.saves
      for (var i = 0; i < saves.length; i++) {
        var temp = saves[i].split("_");
        temp = temp[2].split(".");
        var annee = temp[0];
        //On vérifie que le fichier n'est pas déjà dans la liste
        if ( $("#"+annee).length == 0 ) {
          $(".liste_save").prepend("<li id="+annee+"><a href='./saves/save_de_"+annee+".json' download target='_blank'>Sauvegarde de "+annee+"</a>");
        }
      }
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });
}

/* Fonction servant à récupérer les informations et lancer la création du fichier */
function launch() {
  $.ajax({
    url : './php/getData.php',
    dataType : 'json',
    success : function(data) {
      if (data.error == 0) {
        //On prépare les données à écrire sur le fichier
        var groupes = data.groupes;
        var dataToWrite = new Array();
        //On transforme les objets JSON en tableau pour PHP
        for (var i = 0; i < groupes.length; i++) {
          dataToWrite[i] = JSON.stringify(groupes[i]);
        }
        //On appelle la fonction qui génère le fichier JSON
        generateFile(dataToWrite);
        // NOTE: Refresh la liste + lien
      } else {
        alert(data.error);
      }
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });
}

/* Fonction de génération du fichier de sauvegarde */
function generateFile(groupes) {
  $.ajax({
    url : './php/createFileJson.php',
    type : 'post',
    data : "data="+groupes,
    dataType : 'json',
    success : function(data) {
      if (data.error == 0) {
        getOldSave();
      } else {
        alert("Erreur n° "+data.error);
      }
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });
}
