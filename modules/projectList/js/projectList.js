
function nom ($data){
  $.ajax({
    url : "php/getProjectList.php",
    type : 'POST',
    // on s'attend à récupérer des données structurées en json
    data: $data,
    dataType : 'json',
    // si la réception s'effectue sans problèmes, on redirige l'utilisateur vers le menu
    success : function(text) {
      switch (text.error) {
        case 0:
          setTimeout(function() {
            $(".container").showProjectList(text.projects);
          }, 1000);
          break;
        case 1:
          console.log("error : no project for current user");
          setTimeout(function() {
            $(".loader").html('Aucun projet disponible');
            $(".loader").prepend("<div class='fa fa-times'></div>");
            $(".loader .fa").css({'margin-right' : '10px'}).hover(function() {
              $(this).css({'color' : '#FF5660', 'cursor' : 'default'});
            });
          }, 1000);
          // on affiche à l'écran qu'aucun projet n'est actuellement disponible
          break;
        default:
          console.log("error : unknown error");
          alert("Une erreur inconnue est survenue");

          document.location.href = '../..';
          break;
      }
    },
    error : function() {
      console.log("error : unknown error");
      alert("Une erreur inconnue est survenue");

      document.location.href = '../..';
    }
  });





// fonction showProjectList
// fonction implémentée à jQuery (utilisation $(selector).showProjectList())
// à utiliser sur un objet HTML de type container
// rempli l'objet HTML avec la liste des projets récupérés
  (function($) {
    $.fn.showProjectList = function(projectList) {
      var container = $(this);
      container.html("");
      container.removeClass("load");

      container.append("<ul class='projectlist'>");
      $.each(projectList, function(index, value) {
        container.children(".projectlist").append("<li><span class='projecthead'><span class='level'>"+ this.niveau +"</span><span class='actif'>" + this.actif +" </span><span class='title'>" + this.titre + "</span></span><span class='desc'>" + this.description + "</span></li>");
      });

      $(".projectlist > li").on('click', function () {
        var project = $(".projectlist > li").index($(this));

        $("#_infos-modal").find(".modal-title h2").html("");
        $("#_infos-modal").find(".modal-body p.desc").html("");
        $("#_infos-modal").find(".modal-body p.site").html("");
        $("#_infos-modal").find(".modal-body p.bd").html("");
        $("#_infos-modal").find(".modal-body p.interface").html("");
        $("#_infos-modal").find(".modal-body p.algo").html("");
        $("#_infos-modal").find(".modal-body p.reseaux").html("");
        $("#_infos-modal").find(".modal-body p.rem").html("");
        $("#_infos-modal").find(".modal-body ul.tuteurs").html("");

        $("#_infos-modal").find(".modal-title h2").html(projectList[project].titre);
        $("#_infos-modal").find(".modal-body p.desc").html(projectList[project].description);
        $("#_infos-modal").find(".modal-body p.rem").html("<u>remarques :</u> " + projectList[project].remarques);
        $("#_infos-modal").find(".modal-body ul.tuteurs").append("<li><u>tuteurs :</u></li>");
        $("#_infos-modal").find(".modal-body ul.tuteurs").append("<li>" + projectList[project].tuteur + "</li>");
        if(projectList[project].tuteur_bis != null)
          $("#_infos-modal").find(".modal-body ul.tuteurs").append("<li>" + projectList[project].tuteur_bis + "</li>");

        if(projectList[project].site == "oui"){
          $("#_infos-modal").find(".modal-body p.site").html("Site Dynamique: " + projectList[project].site);
        }
        if(projectList[project].bd == "oui"){
          $("#_infos-modal").find(".modal-body p.bd").html("Base de données: "+projectList[project].bd);
        }
        if(projectList[project].interface == "oui"){
          $("#_infos-modal").find(".modal-body p.interface").html("Interface Graphique: "+projectList[project].interface);
        }
        if(projectList[project].algo == "oui"){
          $("#_infos-modal").find(".modal-body p.algo").html("Algorithme Avancé: "+projectList[project].algo);
        }
        if(projectList[project].reseaux == "oui"){
          $("#_infos-modal").find(".modal-body p.reseaux").html("Réseaux: "+projectList[project].reseaux);
        }

        $("#_infos-modal").modal("show");
      });
    }
  })(jQuery);};
