$(window).load(function() {
  check();
});

//regarde si l'user a deja valider
function check() {
  $.ajax({
    url : "php/check.php",
    type : 'GET',
    dataType : 'json',
    success : function(text) {
      if(text.check == "no") {
        confirm();
      } else if (text.check == "yes") {
        console.log("error : vous avez deja valider");
        alert("Vous avez déjà valider");
        document.location.href = '../..';
      }else{
        console.log("error : vous n'êtes dans aucun groupe");
        alert("Vous vous n'êtes dans aucun groupe");
        document.location.href = '../..';
      }
    },
    error : function() {
      console.log("error");
      alert("Erreur2");
      document.location.href = '../..';
    }
  });
}

//creation du contenu de la page avec le php et l'écrit 
function confirm() {
  $.ajax({
    url : "php/valider.php",
    type : 'GET',
    dataType : 'json',
    success : function(text) {
      var $membres = $('#confirm'); 
      $membres.append(text.reponse);
    },
    error : function() {
      console.log("error");
      alert("Erreur3");
      document.location.href = '../..';
    }
  });
}
