$(window).load(function() { //pose probleme en jquery 2

  loadData();



  var toogleProjectActif = function (){
    var check = $("#project_actif").children(".character-checkbox");
    if(check.hasClass("fa")) {
      check.removeClass("fa fa-check");
    }
    else {
      check.addClass("fa fa-check");
    }
  }

  $("#project_actif").children(".character-checkbox").click(toogleProjectActif);



  $('#addProject_form').submit(function(e) {
    e.preventDefault();
    $("#addProject_form button").addClass("load");
    $("#addProject_form").disableForm();
    setTimeout(function() {
      $("#addProject_form button").addClass("ok");
      var data = {titre: $("#project_title").val(), promotion: $("#project_annee").val()};
      sendMail(data);
      addProject();
    }, 1000);
  });


});

function addProject() {
  var title = $("#project_title").val();
  var desc = $("#project_description").val();
  var annee = $("#project_annee option:selected").val();
  var cotuteur = $("#project_cotuteur").val();
  var more = 'NULL';

  if( $("#project_more").val().length ) {
    more = $("#project_more").val();
  }

  var actif = 1;
  //if( $("#project_actif").children(".character-checkbox").hasClass("fa") ) {
  //  actif = 1;
  //}

  var site = document.forms["form"].elements["project_site"].checked == true;
  if (site == true) {
    site = 1;
  }else{
    site = 0;
  }
  var bd = document.forms["form"].elements["project_bd"].checked == true;
  if (bd == true) {
    bd = 1;
  }else{
    bd = 0;
  }
  var interface = document.forms["form"].elements["project_interface"].checked == true;
  if (interface == true) {
    interface = 1;
  }else{
    interface = 0;
  }
  var algo = document.forms["form"].elements["project_algo"].checked == true;
  if (algo == true) {
    algo = 1;
  }else{
    algo = 0;
  }
  var reseaux = document.forms["form"].elements["project_reseaux"].checked == true;
  if (reseaux == true) {
    reseaux = 1;
  }else{
    reseaux = 0;
  }

  $.ajax({
    url : "./php/addProject.php",
    type : 'post',
    // on envoi l'identifiant de la session PHP et la demande de sauvegarde du cookie en POST
    data : "project_title="+title+"&project_description="+desc+"&project_more="+more+"&project_annee="+annee+"&project_actif="+actif+"&project_cotuteur="+cotuteur+"&project_site="+site+"&project_bd="+bd+"&project_interface="+interface+"&project_algo="+algo+"&project_reseaux="+reseaux,
    // on s'attend à récupérer des données structurées en json
    dataType : 'json',
    // si la réception s'effectue sans problèmes, on redirige l'utilisateur vers le menu
    success : function(text) {
      if(text.error == 0) {
        window.location.replace("../../index.php"); //added by Remi
      } else {
        alert(text.error);
      }
    },
    error : function(xhr) {
      alert("error : "+xhr.error);
    }
  });
}


function loadData() {
  $.ajax({
    url : './php/getData.php',
    dataType : 'json',
    success : function(retour) {
      /* On charge les différentes promotions */
      var promotions = retour.promotion;
      $("#project_annee").append("<option selected disabled >" + "Choisir une promotion");
      for (var i = 0; i < promotions.length; i++) {
        var prom = promotions[i];
        $("#project_annee").append("<option value=" + prom.promotion + ">" + prom.promotion);
        console.log(prom.promotion);
      }

      /* On s'occupe maintenant des tuteurs */
      var tuteurs = retour.tuteurs;
      for (var i = 0; i < tuteurs.length; i++) {
        var tut = tuteurs[i];
        $("#project_cotuteur").append("<option value=" + tut.login + ">" + tut.nom);
      }
    },
    error : function(xhr) {
      alert(xhr.responseText);
    }
  })

  var check = $("#project_actif").children(".character-checkbox");
  check.addClass("fa fa-check");

  // $("#projet_actif").checked = true ;
}

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
    this.children('.form-group').children('textarea').prop('disabled', true);
    this.children('.checkbox').unbind("click");
    this.children('.checkbox').addClass("disabled");
    /*this.children('.from-check').unbind("click");
    this.children('.form_check').addClass("disabled");*/
  }
})(jQuery);
