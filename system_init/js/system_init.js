
$(window).load(function() {

  $("#submit-btn").click(function() {
    var texte = $(this).children("span");
    texte.fadeOut(300, function() {
      texte.text("");
      texte.append("<i class='fa fa-cog fa-spin'></i>");
      texte.fadeIn(300);
    });
    initBD();
  });

});

function initBD() {
  // On récupère les informations pour créer l'administrateur
  var login = $("#admin_login").val();
  var nom = $("#admin_nom").val();
  var prenom = $("#admin_prenom").val();

  // On lance la requête de création de la base de données
  $.ajax({
    url : './php/init_bdd.php',
    type : 'post',
    data : 'login='+login+'&nom='+nom+'&prenom='+prenom,
    dataType : 'json',
    success : function(data) {
      if (data.error === 0) {
        $("#submit-btn").unbind("click");
        $("#submit-btn").children("span").fadeOut(300, function() {
          $(this).children("i").removeClass("fa-cog fa-spin").addClass("fa-check");
          $(this).fadeIn();
        });
        // On laisse un petit laps de temps pour confirmer le succès avant de rediriger
        setTimeout(function() {
          location.href = '..';
        }, 3000)
      } else {
        alert("Une erreur s'est produite");
      }
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  });
}
