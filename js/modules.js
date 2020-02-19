// fonction loadModules
// fonction implémentée à jQuery (utilisation $(selector).loadModules())
// à utiliser sur un objet qui contiendra la liste des modules
// récupère la liste des modules appropriés à l'utilisateur et les affiche
(function($) {
	$.fn.loadModules = function() {
    var output = this;

    output.children(".content").html("");
		output.addClass("load");

		$(".container.searchbox .content").html("");

    $.ajax({
      url : "php/list-modules.php",
  		// on s'attend à récupérer des données structurées en json
      dataType : 'json',
  		// si la réception s'effectue sans problèmes
      success : function(text) {
				// on ajoute les modules à la liste ...
				modules = text.modules;

        console.log(text.modules);

				// pour chaque module à charger
        $.each(text.modules, function(i, value) {
					if ( $("img[alt='" + text.modules[i].name + "']").length == 0 && (text.modules[i].name != "template") ) {
						// on créé le lien qui permettra d'accéder au module
						var link = $("<li />", {
							class : "module",
              id : text.modules[i].folder
						}).append($("<a />", {
							href : "modules/" + text.modules[i].folder + "/index.php",
							html : "<img src='modules/" + text.modules[i].folder + "/" + text.modules[i].icon + "' alt='"+text.modules[i].name+"' /><br/>" + text.modules[i].name
						}));

						output.children('.content').append(link);

						output.children(".content").sortable({
	            placeholder : "ui-sortable-placeholder",
							revert : true,
							scroll : false,
							update : function() { saveModulesPosition(); }
		        });

						visible_searchtabs.push(Array());

						$.ajax({
				      url : "modules/" + text.modules[i].folder + "/search.php",
				  		// on s'attend à récupérer des données structurées en json
				      dataType : 'json',
				  		// si la réception s'effectue sans problèmes
				      success : function(text2) {
								var name = text2.name;
								var search = text2.search;

								searchtab.push({module : text.modules[i].folder, name : name, search : search});

								// on créé le block du module pour la recherche
								var box = $("<ul />", {
									class : "empty module-container " + text.modules[i].folder
								}).append($("<li />", {
									class : "title",
									html : "<img src='modules/" + text.modules[i].folder + "/" + text.modules[i].icon + "' alt='"+name+"' />" + name
								}));

								$(".container.searchbox .content").append(box);
				      }
				    });

					}


        });

				setTimeout(function() {
					output.removeClass("load");
				}, 500);
      }
    });
  }
})(jQuery);

function saveModulesPosition() {
  var list = [];

  $(".module").each( function () {
    list.push($(this).attr("id"));
  } );

  $.ajax({
    url : "php/save-modules-position.php",
    type : 'POST',
    // on envoi la liste des informations à récupérer en POST
    data : "list=" + list,
    // on s'attend à récupérer des données structurées en json
    dataType : 'json',
    // si la réception s'effectue sans problèmes
    success : function(text) {
      
      if(text.error == 0) return true;

    }
  });
}
