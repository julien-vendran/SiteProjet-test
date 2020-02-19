
$(window).load(function() {

  // On ajoute les promotions
  $('select').addPromo();

  // Fonction d'ajout de classe pour la création simultannée de plusieurs classes
  $('#addClass').click(function(){
    $(".classe:last").after('<div class="classe"><!-- Champ de texte pour le nom du groupe --><div class="form-group" id"choixNom"><div class="input-group"><div class="input-group-addon"><i class="fa fa-users"></i></div><input type="text" class="form-control" name="inputNom" placeholder="Nom groupe"/></div></div><!--Champ de choix de promotion--><div class="form-group" id="choixPromo"><div class="input-group"><div class="input-group-addon"><i class="fa fa-sort"></i></div><select class="form-control promoList" id="promoSelect"><option value="Promotion" selected="select" disabled id="def">Promotion</option></select></div></div><!--Champ de recherche pour le délégué 1 du groupe--><div class="form-group" id="choixD1"><div class="input-group"><div class="input-group-addon"><i class="fa fa-user"></i></div><input type="text" class="form-control" name="inputD1" id="inputD1" placeholder="Délégué" autocomplete="off"/></div></div><!--Auto-suggestion de la recherche--><div class="suggest" id="suggestD1"></div><!--Champ de recherche pour le délégué 2 du groupe--><div class="form-group" id="choixD2"><div class="input-group"><div class="input-group-addon"><i class="fa fa-user"></i></div><input type="text" class="form-control" name="inputD2" id="inputD2" placeholder="Délégué 2" autocomplete="off"/></div></div><!--Auto-suggestion de la recherche--><div class="suggest" id="suggestD2"></div></div>');
    // Ajout des promotions dans le dernier select
    $("select:last").addPromo();
    suggest();
  });

  // Activation de la suggestion
  suggest();

  //Fonction permettant l'ajout d'une suggestion et la suppression des suggestions simultanés
  $("input[name='inputD1'], input[name='inputD2']").bind('focus', function() {                  //Lors d'un focus sur le champs
    $(document).bind('click', function(e) {                                   //Lors d'un clic sur la page
        if ( !$(e.target).is('.elem') && !$(e.target).is($(this))) {           //Si ce clic ne soit ni sur la suggestion ni sur le champs
            $(".elem").hide();                                                   //On cache les suggestions
        }
    });
  });


  // On génère les classes quand on clique sur le bouton
  $("#GroupeTD_form").submit(function() {
    $(this).children('.submit-button').children('button:not(.load)').addClass('load');
    makeClasse();
    $('input').attr("disabled", false);
    return false;

  });

});

// Fonction jQuery pour l'ajout des promotions au select
(function($){
  $.fn.addPromo = function(){
    var select = $(this);
    $.ajax({
      url : './php/getPromo.php',
      dataType : 'json',
      success : function(data) {
        if (data.error == 0) {
          // On ajoute les promotions
          $.each(data.promo, function(key, val){  //Pour chaque promotion
            select.append('<option value="'+val.idPromo+'">'+val.niveau+'</option>');  //On ajoute une option
          });
        }
        else {
          alert("Erreur : "+data.error);
        }
      },
      error : function(xhr) {
        alert(xhr.responseText);
      }
    });
  }
})(jQuery);


//Fonction de suggestion de recherche
function suggest(){
  $.ajax({                                  //On lance une requête ajax pour récupérer les membres et leurs promotion
    'url' : 'php/getUserByPromo.php',               //Fichier php
    'type' : 'GET',                               //Méthode
    'datatype' : 'json',                          //Type de données retournées
    success : function(membres, statut){                    //Si la requête aboutit
      membres = JSON.parse(membres);

      $("input[name=inputD1], input[name=inputD2]").keyup(function(){       //Lorsqu'on tape quelque chose dans les champs

        var elements = getFullName(membres.users);                 //On joint nom et prénom de chaque membres

        if($(this).val()){                                    //Si ce champs n'est pas vide
          var select = $(this).parent().parent().parent().children("#choixPromo").children().children('select').children(":selected").text();

          for(var i=0; i < elements.length; i++){

            //On retire les membres qui ne sont pas dans la promotion séléctionnée
            if(select != "Promotion"){

                if(select != elements[i].promo){
                  elements.splice(i, 1);
                  i--;
                }
            }
          }
          var elems = search($(this).val(), elements);          //On lance la recherche des caractères tapés parmis les membres du depinfo
          suggest_add($(this), elems);                          //On ajoute les suggestions nécessaires
        }
        else {                                                //Si le champs est vide
          $(".elem").remove();                                //On supprime les suggestions
        }
      });
    },
    error : function(xhr){                                //Si la requête échoue ou qu'une erreur est retournée
      alert("error : "+xhr.status);                       //On signale l'erreur (pour le test)
    }
  });
}

//Fonction de recherche des membres
function search(char, elems){
  var elems_found = [];           //Tableau contenant les éléments correspondants
  var found;                      //booléen pour savoir si l'élément correspond et quitter les boucles
  $.each(elems, function(key, value){                   //Boucle pour parcourir les Objets élément
    found = false;
    for(var i=0; i<value.nom.length; i++){                  //Boucle pour parcourir la chaine élément courante
      if(value.nom[i].toLowerCase() == char[0].toLowerCase()){ //Si un caractère de cette chaine est égal au premier de l'entree à rechercher
        if(char.length == 1){
          elems_found.push(value);
          found = true;
        }
        else{
          for(var k=1; k<char.length; k++){                   //Pour chaque caractères de la chaine à rechercher
            if(value.nom.length > i+k){                                   //Si la longueur de l'élément courant est supérieure à i+k
              if(value.nom[i+k].toLowerCase() != char[k].toLowerCase()){        //Si le caractère suivant de l'élément courant est différent
                                                                //du suivant de la chaine à rechercher
                break;                                          //On quitte la boucle
              }
              else if(k==char.length - 1){                        //Sinon si k est égal à la longueur de la chaine à rechercher
                elems_found.push({
                  "login" : value.login,
                  "nom" : value.nom
                });                     //On rajoute l'élément courant au tableau des éléments trouvés
                found = true;
                break;
              }
            }
          }
          if(found==true){
            break;
          }
        }
        if(found==true){
          break;
        }
      }
    }
  });
  return elems_found;                               //On retourne le tableau des éléments contenant la chaine de caractère
}

//Fonction pour regrouper le nom et prénom retournés par la bdd
function getFullName(elems){
  var nomComplet = [];

  var first_name;
  var login;
  $.each(elems, function(index, val){                 //Boucle pour parcourir tous les éléments à trier
    fullname = val.prenom+" "+val.nom;
    nomComplet.push({
      "login" : val.login,
      "nom" : fullname,
      "promo" : val.promotion
    });
  });
  return nomComplet;
}

//Fonction de suggestion de recherche qui prend en paramètre le champs actif et les éléments à suggérer
function suggest_add(input, elems){

    $('.elem').remove();                      //On supprime les suggestions présentes
    $sugg = input.parent().parent().next();   //On séléctionne le bloc des suggestions
    var select;

    if (elems.length > 0){                    //Si elems n'est pas vide

      var suggestNone = $('#suggestNone');
      if(suggestNone.length > 0){             //Si le bloc avec pour id suggestNone existe
        $('#suggestNone').remove();           //On le supprime
      }
      var i = 0;
      $.each(elems, function(key, value){       //Pour chaque elements de elems
        if(i<4){                                          //Si il y a moins de 5 suggestions
          $sugg.append($("<div class='elem' id='"+value.login+"'>"+value.nom+"</div>"));   //On ajoute la suggestion courante
          $('#'+value.login+'').click(function(){   //Définition de la fonction du clic sur une suggestion
            input.val(value.login);           //On ajoute le membre correspondant
            $('.elem').remove();
          });

        }
        i++;
      });
    }
    else {          //Aucun element correspondant à la chaine de caractère entrée
      $('.elem').remove();
      $sugg.append($("<div class='elem' id='suggestNone'>Aucun résultat correspondant</div>"));   //On rajoute la sélection suggestNone
    }
    return select;
}


// Fonction qui créer toutes les classes
function makeClasse() {
  //On récupère les données de chaque classe
  $(".classe").each(function(i) {
    var del1 = $(this).children('#choixD1').children().children("input[name='inputD1']").val();
    var del2 = $(this).children('#choixD2').children().children("input[name='inputD2']").val();
    var nom = $(this).children().children().children("input[name='inputNom']").val();
    var promo = $(this).children("#choixPromo").children().children("select").val();

    // On vérifie qu'il y ait bien toutes les informations
    var check = 0;
    check = (nom == "") ? 1 : check;
    check = (del1 == "") ? 2 : check;
    //check = (del2 == "") ? 3 : check;

    if ( check > 0 ) {
      alert("Une classe manque d'informations, sa création est annulée");
      $(this).remove();
    }
    else {
      // On exécute une requête qui va sauvegarder la classe
      $.ajax({
        url : 'php/saveClasse.php',
        type : 'post',
             data : (del2 == "") ? 'nom='+nom+'&d1='+del1+"&promo="+promo: 'nom='+nom+'&d1='+del1+'&d2='+del2+"&promo="+promo,
        dataType : 'json',
        success : function(data) {
          setTimeout(function() {
            $('.submit-button').children('button.load:not(.ok)').addClass('ok');  //Affichage du check sur le bouton
          }, 500);

          if (data.error != 0) {
            alert("Erreur n:  "+data.error);
          }
        },
        error : function(xhr) {
          alert(xhr.responseText);
        }
      });
    }
  });
    
  setTimeout(function(){
    window.location = "../../menu.php";
  }, 10000);
}
