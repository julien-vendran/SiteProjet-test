// fonction enableSearch
// fonction implémentée à jQuery (utilisation $(selector).enableSearch())
// à utiliser sur un objet de type input
// active la recherche à la modification d'un champ de texte
// à la modification, lance la recherche pour un mot clé
(function($) {
	$.fn.enableSearch = function() {
		var input = this;

		input.keyup(function() {
			if(input.val() == "") {
				$('nav.searchbox').removeClass('open');
	      $('nav.modules').removeClass('dismis');

				setTimeout(function() {
					$('.container.searchbox').addClass('load');
				}, 400);

				$.each(visible_searchtabs, function(i, value) {
					visible_searchtabs[i] = Array();
				});
				$('.container.searchbox .content ul.module-container li:not(.title)').remove();
				$('.container.searchbox .content ul.module-container').addClass("empty");
			} else {
				$('nav.searchbox').addClass('open');
				$('nav.modules').addClass('dismis');

				search(input.val());
			}
    });
	}
})(jQuery);

function search(text) {
	$.each(searchtab, function(index, value) {
		$.each(searchtab[index].search, function(index2, value2) {
			var visible_index = visible_searchtabs[index].indexOf(index2);
			var is_visible = visible_index > -1 ? true : false;

			if(searchtab[index].search[index2].toLowerCase().indexOf(text.toLowerCase()) > -1 && !is_visible) {
				visible_searchtabs[index].push(index2);
				$('.container.searchbox .content ul.module-container.'+searchtab[index].module).append("<li class='"+index2+" new'><a href='modules/"+searchtab[index].module+"'>"+searchtab[index].search[index2]+"</a></li>");
				$('.container.searchbox .content ul.module-container.'+searchtab[index].module).removeClass("empty");
				$('.container.searchbox').removeClass('empty');
			} else if(searchtab[index].search[index2].toLowerCase().indexOf(text.toLowerCase()) == -1 && is_visible) {
				visible_searchtabs[index].splice(visible_index, 1);
				$('.container.searchbox .content ul.module-container.'+searchtab[index].module+' li.'+index2).remove();

				if($('.container.searchbox .content ul.module-container.'+searchtab[index].module+' li:not(.title)').length < 1) {
					$('.container.searchbox .content ul.module-container.'+searchtab[index].module).addClass("empty");
				}
			}

			if($('.container.searchbox .content ul.module-container:not(.empty)').length < 1) {
				$('.container.searchbox').addClass("empty");
			}

			if($('.container.searchbox').hasClass('load')) {
				setTimeout(function() {
					$('.container.searchbox .content ul.module-container .new').removeClass('new');
				}, 540);
			} else {
				setTimeout(function() {
					$('.container.searchbox .content ul.module-container .new').removeClass('new');
				}, 10);
			}

		});
	});

	setTimeout(function() {
		$('.container.searchbox.load').removeClass('load');
	}, 500);
}
