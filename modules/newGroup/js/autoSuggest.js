
$(window).load(function(){

  suggest();

  //Fonction permettant l'ajout d'une suggestion et la suppression des suggestions simultanés
  $("#inputChef, #inputMembre").bind('focus', function() {                  //Lors d'un focus sur le champs
    $(document).bind('click', function(e) {                                   //Lors d'un clic sur la page
        if ( !$(e.target).is('.elem') && !$(e.target).is('input')) {           //Si ce clic ne soit ni sur la suggestion ni sur le champs
            $(".elem").hide();                                                   //On cache les suggestions
        }
    });
  });

  $('#newGroup_form').submit(function() {
    $(this).children('.submit-button').children('button:not(.load)').addClass('load');
    newGroup();
    $('.membre, .chefGroupe').remove();
    $('input').attr("disabled", false);
    return false;
  });

});

//Fonction de validation soumission des données en ajax
function newGroup(){
  var chef = $('.chefGroupe').attr("id");   //On récupère le login du chef selectionné
  var login;
  var data = 'chefGroupe='+chef;            //On initialise la chaine de caractère contenant les données $_GET
  $('.membre').each(function(i){            //Pour chaque élément de classe membre
    login = $(this).attr("id");             //On stocke le login du membre
    data = data+'&membre'+i+'='+login;        //On complère la chaine contenant les données
  });
  $.ajax({                            //Requete ajax pour la création du groupe
    'url' : 'php/addGroupe.php',        //Fichier php
    'type' : 'GET',                     //Méthode d'envoi des données
    'data' : data,                      //Données
    'datatype' : 'json',                //Type des données retournées par php
    success : function(retour){
      var ans = JSON.parse(retour);
      if(ans.error == 0){
        setTimeout(function() {
          $('.submit-button').children('button.load:not(.ok)').addClass('ok');  //Affichage du check sur le bouton
        }, 500);
        alert("Le groupe a bien été créé.");                                 //Affichage du texte retourné par php
        setTimeout(function(){
          window.location.replace("../../menu.php");
        }, 500);
      }
      else {
        alert(ans.error);                                 //Affichage du texte retourné par php
        $('.submit-button').children('button').removeClass('load');
      }
      return false;
    },
    error : function(xhr){
      alert("error : "+xhr.status);               //En cas d'erreur, affichage de l'erreur
      return false;
    }
  });
}

//Fonction de suggestion de recherche
function suggest(){
  $.ajax({                                  //On lance une requête ajax pour récupérer les membres du groupe TD
    'url' : 'php/getMembresTD.php',               //Fichier php
    'type' : 'GET',                               //Méthode
    'datatype' : 'json',                          //Type de données retournées
    success : function(membres, statut){                    //Si la requête aboutit
      if(membres.length == 0){
        alert("Tous les membres de votre classe sont déjà dans des groupes.");
        $(location).attr('href', '../../menu.php');
      }
      $("#inputChef, #inputMembre").keyup(function(){       //Lorsqu'on tape quelque chose dans les champs
        var elements = getFullName(membres);                 //On joint nom et prénom de chaque membres

        if($(this).val()){                                    //Si ce champs n'est pas vide
          $.each(selected, function(index, select){           //On retire les membres séléctionnés au tableau des membres
            $.each(elements, function(key, sugg){
              if(select.login == sugg.login){
                elements.splice(key, 1);
                return false;
              }
            });
          });
          var elems = search($(this).val(), elements);          //On lance la recherche des caractères tapés parmis les membres du TD
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
  // alert(elems_found[0]);
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
      "nom" : fullname
    });
  });
  return nomComplet;
}

var selected = [];
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
        }
        i++;
      });
      $('.elem').click(function(){   //Définition de la fonction du clic sur une suggestion
        ajoutMembre($(this));           //On ajoute le membre correspondant
      });
    }
    else {          //Aucun element correspondant à la chaine de caractère entrée
      $('.elem').remove();
      $sugg.append($("<div class='elem' id='suggestNone'>Aucun résultat correspondant</div>"));   //On rajoute la sélection suggestNone
    }
    return select;
}

//Fonction d'ajout de membre
function ajoutMembre(champs){
  var $form = champs.parent().prev();    //On séléctionne le formulaire présent au dessus du lien
  var input = $form.children().children().next('input');    //On sélectionne le champs de recherche
  var $membres = champs.parent().next();                    //On sélectionne le bloc qui contiendra les membres
  var select = $('<div>'+champs.text()+'  <i class="fa fa-times"></i></div>');    //On crée le bloc membre

  if($form.attr('id') == 'choixChef'){        //Si le membre à ajouter est chef
    if($('.chefGroupe').length==0){             //Si il n'y a aucun chef présent
      select.attr("class", "chefGroupe");       //On définit la classe du chef
      select.attr("id", champs.attr("id"));     //On stocke le login dans l'id du div
      $membres.append(select);                  //On ajoute ce membre au bloc contenant le chef
      selected.push({"login" : select.attr("id"),
                    "nom" : select.text()});       //On ajoute le nom du membre aux sélectionnés
      input.val("");                            //On vide le champs
      input.keyup();                            //On lance cet évènement pour déclencher la suppression des suggestions
      input.attr("disabled", true);             //On désactive le champs de recherche de chef
    }
  }
  else if($('.membre').length < 4){             //Sinon si il ya moins de 4 membres
    select.attr('class', 'membre');             //On définit la classe du membre
    select.attr("id", champs.attr("id"));       //On stocke le login dans l'id du div
    $membres.append(select);                    //On ajoute ce membre au bloc contenant tous les membres
    selected.push({"login" : champs.attr("id"),
                  "nom" : select.text()});       //On ajoute le nom du membre aux sélectionnés
    input.val("");                              //On vide le champs
    input.keyup();                              //Suppression des suggestions déclenchée
  }
  if($('.membre').length == 4){                 //Si il y a 4 membres sur la page
    input.attr("disabled", true);               //On désactive le champs de recherche des membres
  }

  select.children().click(function(){           //On définit la fonction de la croix font-awesome (enfant du membre ajouté)
    input.attr("disabled", false);              //On réactive le champs si celui-ci est désactivé
    var id = $(this).parent().attr("id");       //On récupère l'id du membre
    $.each(selected, function(i, val){          //Pour chaque éléments du tableau contenant les membres séléctionnés
      if(val.login == id){
        selected.splice(i, 1);                  //Si l'élément est séléctioné, on le supprime du tableau
      }
    });
    $(this).parent().remove();                  //On supprime le bloc du membre correspondant

  });
}
