console.log("salut");

  $.ajax({
    url : "php/getProjects.php",
    // on s'attend à récupérer des données structurées en json
    dataType : 'json',
    // si la réception s'effectue sans problèmes, on redirige l'utilisateur vers le menu
    success : function(text) {
      switch (text.error) {
        case 0:
          console.log(text);
          setTimeout(function() {
            $(".container").showProjectList(text.projects);
          }, 1000);
          break;
        case 1:
          console.log("error : no project for current user");
          setTimeout(function() {
            $(".loader").html('Aucun de vos projets n\'a été affecté.');
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
      //console.log("error : unknown error");
      //alert("Une erreur inconnue est survenue");

      //document.location.href = '../..';
    }
  });





// fonction showProjectList
// fonction implémentée à jQuery (utilisation $(selector).showProjectList())
// à utiliser sur un objet HTML de type container
// rempli l'objet HTML avec la liste des projets récupérés
  (function($) {
    $.fn.showProjectList = function(projectList) {
      var container = $(this);
      console.log(projectList);
      container.html("");
      container.removeClass("load");

      container.append("<ul class='projectlist'>");
      $.each(projectList, function(index, value) {
        var span = document.createElement('span');
        span.className ="date";
        $.each(this.date, function (index, value) {
          span.innerHTML += this.anneeAffectation + " | "
        });
        container.children(".projectlist").append("<li><span class='projecthead'><span class='idProjet'>"+
            this.idProjet +"</span><span class='title'>"
            + this.titre + " </span> <span class='level'>"+ this.niveau +"</span> <span class='" + span.className +"'> " + span.innerHTML+ " </span> </li>");
      });

      $(".projectlist > li").on('click', function () {
        var project = $(".projectlist > li").index($(this));
        var span = document.createElement('span');
        span.className ="date";
        $.each(projectList[project].date, function (index, value) {
          span.innerHTML += "<span>" + this.anneeAffectation + " | " + this.loginChef + "</span></br>"
        });
        $("#_infos-modal").find(".modal-title h4").html("");
        $("#_infos-modal").find(".modal-body p.desc").html("");
        $("#_infos-modal").find(".modal-body p.rem").html("");
        $("#_infos-modal").find(".modal-body ul.date").html("");

        $("#_infos-modal").find(".modal-title h4").html(projectList[project].titre);
        $("#_infos-modal").find(".modal-body p.rem").html("<u>identifiant du projet :</u> " + projectList[project].idProjet);
        $("#_infos-modal").find(".modal-body p.niveau").html("<u>niveau :</u> " + projectList[project].niveau);
        $("#_infos-modal").find(".modal-body ul.date").append("<li><u>Date d'affectation :</u></li>");
        $("#_infos-modal").find(".modal-body ul.date").append("<li>" + span.innerHTML + "</li>");

        $("#_infos-modal").modal("show");
      });
    }
  })(jQuery);
