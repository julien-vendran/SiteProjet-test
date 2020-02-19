
$(window).load(function() {

  // On charge les données qui servent pour l'édition du projet
  loadData();

  // On charge ensuite les informations du projet
  loadProject();

  // On active le bouton d'activité du projet
  $("#project_actif").click(function() {
    activate();
  });


  // On active le bouton de validation
  $("button[type='submit'].modif").click(function(event) {
    $(this).addClass('load');
    event.preventDefault();
    saveModification();
  });
               
  // On active le bouton de validation
  $("button[type='submit'].duplicate").click(function(event) {
                                              //console.log("dupli");
    $(this).addClass('load');
    event.preventDefault();
    duplicate();
   });
    
               
});

// Fonction qui charge les informations pour l'édition du projet
function loadData() {
  var id = getParameterByName("id");
  $.ajax({
    url : './php/getEditData.php',
    type : 'post',
    data : 'id=' + id,
    dataType : 'json',
    success : function(data) {
      if (data.error == 0) {
        // On ajoute chaque promotion au select

        $.each(data.specification, function (index, val) {
          console.log(index);
          if(val == 1){
              $("#"+index).prop("checked",true);
            }
        });
          var promotions = data.promotion;
          $("#project_annee").append("<option selected disabled >" + "Choisir une promotion"); // on récupère toutes les promotions qui ne sont pas "Enseignant"
          for (var i = 0; i < promotions.length; i++) {
              var prom = promotions[i];
              $("#project_annee").append("<option value=" + prom.promotion + ">" + prom.promotion);
              console.log(prom.promotion);
          }
        // On ajoute ensuite les tuteurs
        for (var i = 0; i < data.tuteurs.length; i++) {
         var tuteur = data.tuteurs[i];
         $("#project_cotuteur").append("<option value=" + tuteur.login + ">" + tuteur.nom + "</option>");
          //$("#project_cotuteur").append("<option value=" + tuteur.login + ">" + tuteur.nom + " " + tuteur.prenom + "</option>");
        }
      } else {
        alert(data.error);
      }
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });
}

// Fonction qui charge les informations du projet sélectionné
function loadProject() {
  var id = getParameterByName("id");
  $.ajax({
    url : './php/getProjectData.php',
    type : 'post',
    data : 'id=' + id,
    dataType : 'json',
    success : function(data) {
      if (data.error == 0) {
        var projet = data.projet;
        // On passe l'id de la promo déjà renseigné en "selected"
        $("#project_annee").children("option[value=" + projet.promotion + "]").prop("selected", true);
        // On selectionne le co-tuteur s'il est renseigné
        if (projet.tuteur_bis) {
          $("#project_cotuteur").children("option[value=" + projet.tuteur_bis + "]").prop("selected", true);
        }
        // On coche la case d'activité si le projet est disponible
        if (projet.actif) {
          $("#project_actif").children(".character-checkbox").append("<i class='fa fa-check'></i>");
        }
        // On remplis les champs textuels
        $("#project_title").val(projet.titre);
        $("#project_description").val(projet.description);
        $("#project_more").val(projet.remarques);

        //chargment des données des spécifiactions

      } else {
        alert(data.error);
      }
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });
}

// Fonction qui récupère l'id dans la QueryString
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

// Fonction d'activité du bouton
function activate() {
  var checkbox = $("#project_actif span.character-checkbox");
  if ( checkbox.children("i").length > 0 ) {
    checkbox.children("i").remove();
  } else {
    checkbox.append("<i class='fa fa-check'></i>");
  }
}

// Fonction qui permet de sauvegarder les modifications
function duplicate() {
  // On récupère les données
  var id = getParameterByName("id");
  var titre = $("#project_title").val();
  var promotion = $("#project_annee").val();
  var desc = $("#project_description").val();
  var more = $("#project_more").val();
  var cotuteur = $("#project_cotuteur").val();
  var actif = ( $("#project_actif span.character-checkbox").children("i").length > 0 ) ? 1 : 0;

  // on verifie si la checkbox est oché si oui on met la valeur 1 sinon 0
  var site = document.forms["form"].elements["project_site"].checked == true;
  if (site == true) {
    site = 1;
  }else{
    site = 0;
  }
  var bd = document.forms["form"].elements["project_bd"].checked == true;
  if (bd == true) {
    bd = 1;
  }else{
    bd = 0;
  }
  var interface = document.forms["form"].elements["project_interface"].checked == true;
  if (interface == true) {
    interface = 1;
  }else{
    interface = 0;
  }
  var algo = document.forms["form"].elements["project_algo"].checked == true;
  if (algo == true) {
    algo = 1;
  }else{
    algo = 0;
  }
  var reseaux = document.forms["form"].elements["project_reseaux"].checked == true;
  if (reseaux == true) {
    reseaux = 1;
  }else{
    reseaux = 0;
  }

  // On effectue la requête Ajax qui va sauvegarder toutes les informations
  $.ajax({
    url : './php/duplicate.php',
    type : 'post',
    data : 'id='+id+'&titre='+titre+'&promotion='+promotion+'&description='+desc+'&remarques='+more+'&cotuteur='+cotuteur+'&actif='+actif+"&project_site="+site+"&project_bd="+bd+"&project_interface="+interface+"&project_algo="+algo+"&project_reseaux="+reseaux,
    dataType : 'json',
    success : function(data) {
      if (data.error == 0) {
        setTimeout(function() {
          $('.submit-button').children('button.load:not(.ok)').addClass('ok');  //Affichage du check sur le bouton
        }, 100);

        alert("Le projet a bien été dupliqué");
        setTimeout(function(){
          window.location.href = '..';
        }, 500);
      } else {
        alert(data.error);
      }
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });
}

                          
// Fonction qui permet de sauvegarder les modifications
function saveModification() {
  // On récupère les données
  var id = getParameterByName("id");
  var titre = $("#project_title").val();
  var annee = $("#project_annee").val();
  var desc = $("#project_description").val();
  var more = $("#project_more").val();
  var cotuteur = $("#project_cotuteur").val();
  var actif = ( $("#project_actif span.character-checkbox").children("i").length > 0 ) ? 1 : 0;

    // on verifie si la checkbox est oché si oui on met la valeur 1 sinon 0
    var site = document.forms["form"].elements["project_site"].checked == true;
    if (site == true) {
        site = 1;
    }else{
        site = 0;
    }
    var bd = document.forms["form"].elements["project_bd"].checked == true;
    if (bd == true) {
        bd = 1;
    }else{
        bd = 0;
    }
    var interface = document.forms["form"].elements["project_interface"].checked == true;
    if (interface == true) {
        interface = 1;
    }else{
        interface = 0;
    }
    var algo = document.forms["form"].elements["project_algo"].checked == true;
    if (algo == true) {
        algo = 1;
    }else{
        algo = 0;
    }
    var reseaux = document.forms["form"].elements["project_reseaux"].checked == true;
    if (reseaux == true) {
        reseaux = 1;
    }else{
        reseaux = 0;
    }

  // On effectue la requête Ajax qui va sauvegarder toutes les informations
  $.ajax({
    url : './php/saveModification.php',
    type : 'post',
    data : 'id='+id+'&titre='+titre+'&annee='+annee+'&description='+desc+'&remarques='+more+'&cotuteur='+cotuteur+'&actif='+actif+"&project_site="+site+"&project_bd="+bd+"&project_interface="+interface+"&project_algo="+algo+"&project_reseaux="+reseaux,
    dataType : 'json',
    success : function(data) {
      if (data.error == 0) {
        setTimeout(function() {
          $('.submit-button').children('button.load:not(.ok)').addClass('ok');  //Affichage du check sur le bouton
        }, 100);

        alert("Le projet a bien été modifié");
        setTimeout(function(){
          window.location.href = '..';
        }, 500);
      } else {
        alert(data.error);
      }
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });
}
