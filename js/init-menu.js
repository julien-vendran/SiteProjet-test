var modules = Array();
var searchtab = Array();
var visible_searchtabs = Array();

$(window).load(function() {
  $('ul.menu .user_id').initUserId();

  $('ul.menu .next-event').initNextEvent();

  $('ul.menu .deconnect').click(function() {deconnect();});

  $('nav.container.modules').loadModules();

  $("#search_input").enableSearch();
});

// fonction initUserId
// fonction implémentée à jQuery (utilisation $(selector).initUserId())
// rempli l'objet avec le login de l'utilisateur
(function($) {
	$.fn.initUserId = function() {
    var output = this;

    // on envoie, en ajax, le login et le mot de passe de l'utilisateur
  	// à la page ldap-auth qui vérifie la connexion ldap en PHP
    $.ajax({
      url : "php/user.php",
      type : 'POST',
  		// on envoi la liste des informations à récupérer en POST
      data : "infos=uid",
  		// on s'attend à récupérer des données structurées en json
      dataType : 'json',
  		// si la réception s'effectue sans problèmes
      success : function(text) {
        output.text(text.uid);
      }
    });
  }
})(jQuery);


// fonction initNextEvent
// fonction implémentée à jQuery (utilisation $(selector).initNextEvent())
// rempli l'objet avec le prochain évènement
(function($) {
  $.fn.initNextEvent = function() {
    var output = this;

    // on envoie, en ajax, le login et le mot de passe de l'utilisateur
    // à la page ldap-auth qui vérifie la connexion ldap en PHP
    $.ajax({
      url : "php/next_event.php",
      type : 'POST',
      // on envoi la liste des informations à récupérer en POST
      data : "infos=uid",
      // on s'attend à récupérer des données structurées en json
      dataType : 'json',
      // si la réception s'effectue sans problèmes
      success : function(text) {
        // si il n'existe pas d'évènement prochain, on arrette le script
        if(text.planning.length <= 0) {
          $('ul.menu .title').remove();
          return false;
        }

        // on créé le conteneur du jour ...
        switch(parseInt(text.planning[0].date.w)) {
          case 0:
            var day = "<span class='day'><span class='w'>dim</span><span class='d'>"+text.planning[0].date.d+"</span></span>";
            break;

          case 1:
            var day = "<span class='day'><span class='w'>lun</span><span class='d'>"+text.planning[0].date.d+"</span></span>";
            break;
            
          case 2:
            var day = "<span class='day'><span class='w'>mar</span><span class='d'>"+text.planning[0].date.d+"</span></span>";
            break;
            
          case 3:
            var day = "<span class='day'><span class='w'>mer</span><span class='d'>"+text.planning[0].date.d+"</span></span>";
            break;
            
          case 4:
            var day = "<span class='day'><span class='w'>jeu</span><span class='d'>"+text.planning[0].date.d+"</span></span>";
            break;
            
          case 5:
            var day = "<span class='day'><span class='w'>ven</span><span class='d'>"+text.planning[0].date.d+"</span></span>";
            break;
            
          case 6:
            var day = "<span class='day'><span class='w'>sam</span><span class='d'>"+text.planning[0].date.d+"</span></span>";
            break;
        }

        var hour = "";
        if(text.planning[0].date.mn != 0 && text.planning[0].date.h != 0) {
          // si une heure est définie, on créé le conteneur de l'heure
          hour = "<span class='hour'>"+text.planning[0].date.h+":"+text.planning[0].date.mn+"</span>";
        }

        // on créé le conteneur du titre ...
        var title = "<span class='title'>"+text.planning[0].title+"</span>";

        // on créé le conteneur de la description ...
        var desc = "<span class='desc'>"+text.planning[0].desc+"</span>";

        // enfin, on assemble l'évènement
        output.html(day+title+hour+desc);
      }
    });
  }
})(jQuery);