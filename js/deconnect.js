// fonction deconnect
// déconnecte l'utilisateur en supprimant les variables de session
function deconnect() {
  // on envoie, en ajax, une demande de deconnexion
  // à la page deconnect qui videra la mémoire et deconnectera l'utilisateur
  $.ajax({
    url : "php/deconnect.php",
    // on s'attend à récupérer des données structurées en json
    dataType : 'json',
    // si la réception s'effectue sans problèmes
    success : function(text) {
      if(text.error == 0) {
        $(location).attr("href", "index.php");
      }
    }
  });
}
