$(window).load( function () {
  $.ajax({
    url : "php/auto-connect.php",
    type : 'POST',
    // on s'attend à récupérer des données structurées en json
    dataType : 'json',
    // si la réception s'effectue sans problèmes
    success : function(text) {
      
      // si l'utilisateur a bien enregistré des identifiants ...
      if(text.error == 0) {
        // on récupère ses identifiants
        var logs = text.logs.split(",");
        var login = logs[0];
        var password = logs[1];

        // on rempli ses identifiants ...
        $("#user_login").val(login);
        $("#user_password").val(password);
        $("#connect-form .checkbox").addClass("show");

        // on envoi le formulaire
        $("#connect-form").submit();
      }

    }
  });
} );