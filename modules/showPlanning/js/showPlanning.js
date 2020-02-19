
$(window).load(function() {

  // On charge le planning déjà enregistré
  loadPlanning();
});

// Fonction permettant de charger les dates déjà enregistrées
function loadPlanning() {

  $.ajax({
    url : "php/getPlanning.php",
    type : 'GET',
    data : "",
    // on s'attend à récupérer des données structurées en json
    dataType : 'json',
    // si la réception s'effectue sans problèmes
    success : function(text) {
      console.log(text);
      if(text.error == 0) {
        var events = [];
        // on créé le tableau des évènements en fonction des mois ...
        $.each(text.planning, function (index, value) {
          var infos = {
            "id" : value.id,
            "y" : value.date.y,
            "d" : value.date.d,
            "h" : value.date.h,
            "mn" : value.date.mn,
            "w" : value.date.w,
            "title" : value.title,
            "desc" : value.desc
          };

          if(parseInt(value.date.m) >= 9) var id = parseInt(value.date.m) - 8;
          else var id = parseInt(value.date.m) + 4;

          if(events[id] == null) events[id] = [infos];
          else events[id].push(infos);
        });

        // on affiche le planning
        showPlanning(events);

        return true;
      }
    },
    // sinon, on signale une erreur
    error : function(xhr) {
      console.log("error : error while trying to get planning");
    }
  });
}

function showPlanning(events) {
  // on récupère la date actuelle
  var now = new Date();

  if(now.getMonth >= 8) var year = parseInt(now.getFullYear());
  else var year = parseInt(now.getFullYear() - 1);

  $.each(events, function (index, value) {
    // si il y a un évènement dans le mois ...
    if(value != null) {
      // on ajoute le tableau qui contiendra les évènements du mois ...
      switch(index) {
        case 1:
          $("#planning").append("<li><ul id='container-1'><li class='title'>Septembre " + year + "</li></ul></li>");
          break;

        case 2:
          $("#planning").append("<li><ul id='container-2'><li class='title'>Octobre " + year + "</li></ul></li>");
          break;
          
        case 3:
          $("#planning").append("<li><ul id='container-3'><li class='title'>Novembre " + year + "</li></ul></li>");
          break;
          
        case 4:
          $("#planning").append("<li><ul id='container-4'><li class='title'>Décembre " + year + "</li></ul></li>");
          break;
          
        case 5:
          $("#planning").append("<li><ul id='container-5'><li class='title'>Janvier " + (year+1) + "</li></ul></li>");
          break;
          
        case 6:
          $("#planning").append("<li><ul id='container-6'><li class='title'>Février " + (year+1) + "</li></ul></li>");
          break;
          
        case 7:
          $("#planning").append("<li><ul id='container-7'><li class='title'>Mars " + (year+1) + "</li></ul></li>");
          break;
          
        case 8:
          $("#planning").append("<li><ul id='container-8'><li class='title'>Avril " + (year+1) + "</li></ul></li>");
          break;
          
        case 9:
          $("#planning").append("<li><ul id='container-9'><li class='title'>Mai " + (year+1) + "</li></ul></li>");
          break;
          
        case 10:
          $("#planning").append("<li><ul id='container-10'><li class='title'>Juin " + (year+1) + "</li></ul></li>");
          break;
          
        case 11:
          $("#planning").append("<li><ul id='container-11'><li class='title'>Juillet " + (year+1) + "</li></ul></li>");
          break;
          
        case 12:
          $("#planning").append("<li><ul id='container-12'><li class='title'>Aout " + (year+1) + "</li></ul></li>");
          break;
      }

      // on rempli le tableau avec les évènements
      $.each(value, function (index2, value2) {
        // on créé le conteneur du jour ...
        switch(parseInt(value2.w)) {
          case 0:
            var day = "<span class='day'><span class='w'>dim</span><span class='d'>"+value2.d+"</span></span>";
            break;

          case 1:
            var day = "<span class='day'><span class='w'>lun</span><span class='d'>"+value2.d+"</span></span>";
            break;
            
          case 2:
            var day = "<span class='day'><span class='w'>mar</span><span class='d'>"+value2.d+"</span></span>";
            break;
            
          case 3:
            var day = "<span class='day'><span class='w'>mer</span><span class='d'>"+value2.d+"</span></span>";
            break;
            
          case 4:
            var day = "<span class='day'><span class='w'>jeu</span><span class='d'>"+value2.d+"</span></span>";
            break;
            
          case 5:
            var day = "<span class='day'><span class='w'>ven</span><span class='d'>"+value2.d+"</span></span>";
            break;
            
          case 6:
            var day = "<span class='day'><span class='w'>sam</span><span class='d'>"+value2.d+"</span></span>";
            break;
        }

        var hour = "";
        if(value2.mn != 0 && value2.h != 0) {
          // si une heure est définie, on créé le conteneur de l'heure
          hour = "<span class='hour'>"+value2.h+":"+value2.mn+"</span>";
        }

        // on créé le conteneur du titre ...
        var title = "<span class='title'>"+value2.title+"</span>";

        // on créé le conteneur de la description ...
        var desc = "<span class='desc'>"+value2.desc+"</span>";

        // enfin, on assemble l'évènement
        $("#planning #container-" + index).append("<li id='"+value2.id+"'>"+day+title+hour+desc+"</li>");
      });
    }
  });
}
