// fonction enableForm
// fonction implémentée à jQuery (utilisation $(selector).enableForm())
// à utiliser sur un objet de type formulaire
// active les champs du formulaire et annule l'envoi basique du formulaire
// à l'envoi, exécute la fonction connect
(function($) {
	$.fn.enableForm = function() {
		this.unbind("submit");
		this.submit(function() {
			$(this).connect();
			return false;
		});
		this.children('.form-group').children('.input-group').children('input').prop('disabled', false);
		this.children('.form-group').children('.input-group').children('select').prop('disabled', false);
    this.children('.checkbox').click(function() {
			$(this).toggleClass('show');
		});
		this.children('.checkbox.disabled').removeClass("disabled");
  }
})(jQuery);


// fonction disableForm
// fonction implémentée à jQuery (utilisation $(selector).disableForm())
// à utiliser sur un objet de type formulaire
// désactive les champs du formulaire et annule l'envoi basique du formulaire ET l'envoi ajax du formulaire
(function($) {
	$.fn.disableForm = function() {
		this.unbind("submit");
		this.submit(function() {
			return false;
		});
    this.children('.form-group').children('.input-group').children('input').prop('disabled', true);
		this.children('.form-group').children('.input-group').children('select').prop('disabled', true);
		this.children('.checkbox').unbind("click");
		this.children('.checkbox').addClass("disabled");
  }
})(jQuery);


// fonction connect
// fonction implémentée à jQuery (utilisation $(selector).conect())
// à utiliser sur un objet de type formulaire
// vérifie la validité syntaxique des identifiants (#user_login et #user_password)
// si les identifiants sont corrects, envoie les paramètres à la fonction ldapAuth
(function($) {
	$.fn.connect = function() {
    var form = this;

		// login de l'utilisateur
    var ldap_login = form.children('.form-group').children('.input-group').children('#user_login').val();

		// mot de passe de l'utilisateur
    var ldap_password = form.children('.form-group').children('.input-group').children('#user_password').val();

    var valid_login = false;
    var valid_password = false;

		// timer avant d'envoyer les données à la fonction ldapAuth
    var timer = 500;

		// on passe le bouton en chargement et on desactive le formulaire
		form.children('.submit-button').children('button:not(.load)').addClass('load');
    form.disableForm();

		// on vérifie que le login et le mot de passe ne sont pas vides
    valid_login = !$.isEmptyObject(ldap_login);
    valid_password = !$.isEmptyObject(ldap_password);

    setTimeout(function() {
			// on enlève les erreurs du formulaires (login/mot de passe incorrect)
      form.children('.form-group.error').removeClass('error');

      if(valid_login && valid_password) {
				// si tout va bien, on execute la fonction ldapAuth
        ldapAuth(ldap_login, ldap_password, form);
      } else {
				// sinon
				// on préviens l'utilisateur que le login n'est pas correct
        if(!valid_login) form.children('.form-group:not(.error)').has('#user_login').addClass('error');

				// on préviens l'utilisateur que le mot de passe n'est pas correct
        if(!valid_password) form.children('.form-group:not(.error)').has('#user_password').addClass('error');

				// on réactive le formulaire et on stop le chargement du bouton
        form.enableForm();
        form.children('.submit-button').children('button.load').removeClass('load');
      }
    }, timer);
	};
})(jQuery);



// fonction ldapAuth
// paramètres:
//   login: identifiant de l'utilisateur
//   password: mot de passe de l'utilisateur
//   form: objet jQuery de type formulaire pour gérer les chargements...
// vérifie l'existence et la validité de l'utilisateur dans le module LDAP
// si ils sont corrects, connecte l'utilisateur
function ldapAuth(login, password, form) {
	// on envoie, en ajax, le login et le mot de passe de l'utilisateur
	// à la page ldap-auth qui vérifie la connexion ldap en PHP
  $.ajax({
    url : "php/ldap-auth.php",
    type : 'POST',
		// on envoi le login et le mot de passe en POST
    data : "login=" + login + "&password=" + password + "&save=" + form.children('.checkbox').hasClass('show'),
		// on s'attend à récupérer des données structurées en json
    dataType : 'json',
		// si la réception s'effectue sans problèmes
    success : function(text) {
			// on vérifie l'erreur retournée
      switch(text.error) {
				// erreur 1: uid ldap introuvable
				case 1:
					// on préviens l'utilisateur que le login n'est pas correct
					form.children('.form-group:not(.error)').has('#user_login').addClass('error');
					// on réactive le formulaire et on stop le chargement du bouton
					form.enableForm();
		      form.children('.submit-button').children('button.load').removeClass('load');
					break;

				// erreur 2: connexion à la base avec l'uid (valide) et le mot de passe impossible
				case 2:
					// on préviens l'utilisateur que le mot de passe n'est pas correct
					form.children('.form-group:not(.error)').has('#user_password').addClass('error');
					// on réactive l'envoi du formulaire et on stop le chargement du bouton
					form.enableForm();
		      form.children('.submit-button').children('button.load').removeClass('load');
					break;

				// erreur 0: tout s'est bien passé, l'uid à été trouvé et la connexion, associée au mot de passe, est établie
				case 0:
					// on passe le bouton en statut OK
		      form.children('.submit-button').children('button.load').addClass('ok');
					// on connecte l'utilisateur ...
          //userAuth(form.children('.form-group').children('.input-group').children('select').val(), form.children('.checkbox').hasClass('show'));
      	  userAuth(text.usertype, form);
					break;

				// par défaut (si une autre erreur se produit)
				default:
					// on recharge le formulaire
					location.reload();
					break;
			}
    },
		error: function() {
			// on réactive le formulaire et on stop le chargement du bouton
			form.enableForm();
			form.children('.submit-button').children('button.load').removeClass('load');
		}
  });
}

// fonction userAuth
// paramètres save: enregistrement ou non d'un cookie pour la connexion automatique (true/fase)
// connecte l'utilisateur au service de l'intranet
function userAuth(type, form) {
	// on envoie, en ajax, l'id de la session courrante PHP
	// à la page user-auth qui connecte l'utilisateur et initialise les variables de session
	$.ajax({
		url : "php/user-auth.php",
		type : 'POST',
		// on envoi l'identifiant de la session PHP et la demande de sauvegarde du cookie en POST
    //data : "level="+level+"&save="+save,
		data : "usertype=" + type,
		// on s'attend à récupérer des données structurées en json
		dataType : 'json',
		// si la réception s'effectue sans problèmes, on redirige l'utilisateur vers le menu
		success : function(text) {

			if(text.error == 0) {
				setTimeout(function() {
					location.reload();
				}, 500);
			}
		},
		error : function() {
			// on réactive le formulaire et on stop le chargement du bouton
			form.enableForm();
			form.children('.submit-button').children('button.load').removeClass('load');
		}
	});
}

// quand la page est chargée, on active le formulaire de connexion pour permettre l'envoi en ajax...
$(window).load(function() {
	$("#connect-form").enableForm();
});
