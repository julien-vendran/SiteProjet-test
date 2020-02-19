var results = 0;

Dropzone.autoDiscover = false;

$(window).load(function() {
  $("section#dropzone").dropzone({
    url: "php/uploadFile.php",
    acceptedFiles: ".txt",
    method: "post",
    clickable: true,
    init: function() {
      this.on("addedfile", function(file) {
       $("#dropzone .text").height($("#dropzone .text").height() + "px");
       $("#dropzone .text").animate({
         "height": 0,
         "opacity": 0
       }, 500, function() {
         $("#dropzone .text").css("display", "none");
       });
     });
     
     this.on("success", function(file, server) {
       if(server == "") { window.location.href("../"); }
       
       $(".container").css("display", "block");
       setTimeout(function() {
         $(".container").addClass("load");
         setTimeout(function() {
           searchAffectations(server);
         }, 1000);
       }, 500);
     });
    }
  });

  $('.container').on('submit', function () {
    return false;
  });
});

var affectations = new Array();
var file = "";
function searchAffectations(txtFile) {
  $.ajax({
    url : 'php/getAffectations.php',
    type : 'POST',
    data : 'file=' + txtFile,
    dataType : 'json',
    success : function(text) {
      if(text.error == 0) {
        results += text.size;
        
        $(".container").removeClass("load");
        $(".container .results").text(results + " affectations trouvées :");

        affectations = text.affectations;
        file = text.file;

        $.each(affectations, function (id, val) {
          $(".container .affectations-list").append("<li><input type='checkbox' name='affectations' value='" + id + "' checked /> <span>Projet <b>" + val.project + "</b> affecté au groupe <b>" + val.group + "</b>.</span></li>");
        })

        $(".container .affectations-list li span").on('click', function (e) {
          $(this).parent().children('input').click();
          e.preventDefault();
          return false;
        });

        $(".container .submit-button").removeClass("close");

        $(".container").on('submit', function () {
          $(this).saveAffectations();
        });
      }

    },
    error : function(xhr) {
      alert(xhr.error);
    }
  });
}


// fonction saveAffectations
// fonction implémentée à jQuery (utilisation $(selector).saveAffectations())
// à utiliser sur un objet de type form
// enregistre les affectations dans la base de données
(function($) {
  $.fn.saveAffectations = function() {
    var form = $(this);

    form.unbind('submit');
    form.on('submit', function () {
      return false;
    });

    // on active le chargement du boutton
    form.find('div.submit-button').children('button').addClass('load');

    var save = new Array();

    $.each(form.find('.affectations-list input:checked'), function (id, val)  {
      save.push(affectations[$(this).val()].group);
    });
    
    $.ajax({
      url : "php/saveAffectations.php",
      type : 'POST',
      data : "file="+file+"&save="+save,
      // on s'attend à récupérer des données structurées en json
      dataType : 'json',
      // si la réception s'effectue sans problèmes
      success : function(text) {
        if(text.error == 0) {
          setTimeout(function() {
            form.find('div.submit-button').children('button').addClass('ok');
            console.log(text);
          }, 500);
        } else {
          // on arrête le chargement du boutton
          form.find('div.submit-button').children('button').removeClass('load');
        }
      },
      // sinon, on signale une erreur
      error : function(xhr) {
        // on arrête le chargement du boutton
        form.find('div.submit-button').children('button').removeClass('load');
      }
    });
  }
})(jQuery);
