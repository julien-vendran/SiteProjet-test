$(window).load(function(){
  // Affichage des projets et des voeux du groupe
  displayProjects();

  // // Fonction de recherche
  $('#searchInput').keyup(function(){
    // Si le champs n'est pas vide
    var str = $('#searchInput').val();
    $('#projectList').children().each(function(i){
      if(! $(this).hasClass("wish")){
        $(this).removeClass('noMatch');
        var project = $(this);
        var projectTitle = $(this).children('.title').html();
        var projectDesc = $(this).children('.infos').html();
        var words = str.split(" ");
        $.each(words, function(key, word){
          if(projectTitle.toLowerCase().indexOf(word.toLowerCase()) < 0 && projectDesc.toLowerCase().indexOf(word.toLowerCase()) < 0){
            project.addClass("noMatch");
          }
        });
      }
    });
  });

  //Liste triable en drag&drop
  $('#wishList').sortable({
    containment : "#wishList",
    axis : "y",
    opacity : 0.6
  });

  $('form').submit(function() {
    $(this).children('.submit-button').children('button:not(.load)').addClass('load');
    submitWishes();
    $('div').attr('disabled', true);
    return false;
  });

});

//Fonction de validation soumission des données en ajax
function submitWishes(){
  // Mise en place des arguments $_GET
  var args = "";
  $('#wishList').children().each(function(i){
    var classe = i+1;
    args = args + classe + "=" + $(this).attr("id") + "&";
  });
  args = args.substring(0, args.length-1);
  // Requete ajax pour l'insertion des données dans bdd
  $.ajax({
    'url' : 'php/chooseProject.php',
    'type' : 'GET',
    'data' : args,
    'datatype' : 'json',
    success: function(ret){
      var ans = JSON.parse(ret);
      if(ans.error == 0){
        setTimeout(function() {
          $('.submit-button').children('button.load:not(.ok)').addClass('ok');  //Affichage du check sur le bouton
          setTimeout(function(){
            window.location = "../../";
          }, 200);
        }, 500);
        alert("Les voeux ont été enregistrés");                                 //Affichage du texte retourné par php
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


function displayProjects(){
  $.ajax({
    'url': 'php/getProjects.php',
    'type': 'GET',
    'datatype': 'json',
    success: function(data, status){

      $.each(JSON.parse(data), function(key, project){
        // Affichage des projets
        $('#projectList').append('<div class="project" id="projet'+project.idProjet+'"><div title="Cliquez pour voir les détails" class="title">'+project.titre+'</div><i title="Cliquez pour ajouter aux voeux" class="fa fa-plus"></i><div class="infos">'+project.description+'</div></div>');

        displayDesc('projet'+project.idProjet);

        // Ajout du projet en voeux
        $('#projet'+project.idProjet).children().next('i').click(function(){
          if($('#wishList').children().length < 5){
            $(this).parent().addClass('wish');
            $('#wishList').append('<div class="project" id="'+project.idProjet+'"><i class="fa fa-bars"></i><div title="Cliquez pour voir les détails" class="title">'+project.titre+'</div><i class="fa fa-times"></i><div class="infos">'+project.description+'</div></div>');
            displayDesc(project.idProjet);

            // Fonction de suppresion du voeux
            $('#'+project.idProjet).children('.fa-times').click(function(){
              $('#'+project.idProjet).remove();                     //Suppression du div voeux
              $('#projet'+project.idProjet).removeClass("wish");  //Apparition du div projet
            });
          }
        });


      });
      // On affiche les voeux
      displayWishes();
    },
    error: function(xhr){
      alert("error:"+xhr.status);
    }
  });
}

function displayWishes(){
  $.ajax({
    "url" : "php/getWishes.php",
    "type" : "GET",
    "datatype" : "json",
    success : function(data, status){
      var ans = JSON.parse(data);
      if(ans.error == null && ans.length > 0){
        $.each(ans, function(key, wish){
          $('#projet'+wish.idProjet).addClass("wish");  //On cache le projet en question grace à la classe wish

          // On affiche le voeux
          $('#wishList').append('<div class="project" id="'+wish.idProjet+'"><i class="fa fa-bars"></i><div title="Cliquez pour voir les détails" class="title">'+wish.titre+'</div><i class="fa fa-times"></i><div class="infos">'+wish.description+'</div></div>');
          displayDesc(wish.idProjet);  //Affichage de la description

          // Fonction de suppresion du voeux
          $('#'+wish.idProjet).children('.fa-times').click(function(){
            $('#'+wish.idProjet).remove();                     //Suppression du div voeux
            $('#projet'+wish.idProjet).removeClass("wish");  //Apparition du div projet
          });

        });
      }
    },
    error : function(xhr){
      alert("Error : " + xhr.status);
    }
  })
}

function displayDesc(idProject){
  // Evenement d'affichage de la description lors d'un clic
  $('#'+idProject).children('.title').data('clicks', true);  //Initialisation d'une variable click pour savoir si un clic a été effectué
  $('#'+idProject).children('.title').click(function(){
    var clicks = $(this).data('clicks');                    //Lors d'un clic, on définit la variable pour déterminer si le projet était cliqué ou non
    if(clicks){
      $(this).next().next().css("display", "block");        //Si non, on affiche la description
    }
    else {
      $(this).next().next().css("display", "none");         //Si oui, on cache la description
    }
    $(this).data('clicks', !clicks);                        //On change la valeur de l'attribut click
  });
}
