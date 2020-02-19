
$(window).load(function() {

  // On charge le créneau du groupe de l'utilisateur connecté
  loadCreneau();

});

// Fonction permettant de charger l'horaire d'affectation
function loadCreneau() {
  $.ajax({
    url : './php/loadCreneau.php',
    dataType : 'json',
    success : function(data) {
      if (data.error == 0) {
        var horaire = data.horaire;
        if (data.horaire == null) {
          $(".horaire").append("<span class='creneau'>Vous n'avez pas encore été affecté</span>");
        } else {
          $(".horaire").append("<span class='creneau'>" + horaire + "</span>");
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
