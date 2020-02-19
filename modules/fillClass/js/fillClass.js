
// les variables ...
var users = [];
var visible = [];
var addedList = [];
var except = [];
var id = null;

$(window).load( function () {
  $.ajax({
    url : "php/getClass.php",
    type : "post",
    data : "",
    dataType : "json",
    success : function(text) {

      if(text.error == 0) {
        id = text.id;

        $("#class-modal .name").text(text.name);

        $("#group .name").text(text.name);
        $("#group .nb").text(text.class.length);

        if(text.class != "") {
          $.each(text.class, function (index, value) {
            $("#class-modal .modal-body ul").append("<li id='" + value.userid + "'><span class='icon'></span><span class='username'>" + value.firstname + " " + value.lastname + "</span> - <span class='userid'>" + value.userid + "</span><i class='fa fa-close'></i></li>");
            addedList.push(value);
          });
          
          $("#class-modal .userlist li").on('click', function (e) {
            delStudent( $(this).attr('id') );
            e.stopPropagation();
            return false;
          });
        }
      }

    },
    error : function(xhr) {

      console.log(xhr);

    }
  });

  $("#searchbar").on("keyup", function () {
    searchUser($(this).val());
  });



  $("#searchform .userlist").sortable({
    placeholder : "ui-sortable-placeholder",
    revert : true,
    scroll : false,
    cursorAt: { top: 26, left: 26 },
    start: function () {
      $("#searchform .userlist li").unbind('click');

      return true;
    },
    stop: function () {
      
      $("#searchform .userlist li").on('click', function (e) {
        addStudent( $(this).attr('id'), false );
        e.stopPropagation();
        return false;
      });

      return true;
    }
  });

  $("#group").droppable({
    activeClass: "ui-state-highlight",
    hoverClass: "drop-hover",
    drop: function (event, ui) {
      $(".userlist .ui-sortable-helper").css("display", "none");
      $(".userlist .ui-sortable-placeholder").css("height", "0");

      addStudent( ui.draggable.attr('id'), false );

      return true;
    }
  });
} );

function updateUsers( query ) {
  // pour chaque utilisateur déjà enregistré (donc en cache) ...
  $.each(users, function (index, value) {
    //si l'utilisateur correspond à l'occurence et n'est pas visible ...
    if((value.userid.toLowerCase().indexOf(query.toLowerCase()) > -1 || value.firstname.toLowerCase().indexOf(query.toLowerCase()) > -1 || value.lastname.toLowerCase().indexOf(query.toLowerCase()) > -1) && visible.indexOf(value.userid) == -1) {
      // on affiche l'occurence
      if($("#searchform .userlist #" + value.userid).length == 0) {
        $("#searchform .userlist").append("<li id='" + value.userid + "' class='show'><span class='icon'></span><span class='username'>" + value.firstname + " " + value.lastname + "</span> - <span class='userid'>" + value.userid + "</span><i class='fa fa-plus'></i></li>");
      }
      $("#searchform .userlist #" + value.userid).css("height", "52px");
      $("#searchform .userlist #" + value.userid).css("opacity", "1");
      // on ajoute l'occurence dans le tableau des utilisateurs affichés
      visible.push(value.userid);
    } else if(value.userid.toLowerCase().indexOf(query) == -1 && value.firstname.toLowerCase().indexOf(query) == -1 && value.lastname.toLowerCase().indexOf(query) == -1 && visible.indexOf(value.userid) > -1) {
      // on supprime l'occurence dans le tableau affiché
      $("#searchform .userlist #" + value.userid).css("height", "0");
      $("#searchform .userlist #" + value.userid).css("opacity", "0");
      // on supprime l'occurence dans le tableau des utilisateurs affichés
      visible.splice(visible.indexOf(value.userid),1);
    }

    if (query == "") {
      visible = [];

      // on vide tout
      $("#searchform .userlist li").css("height", "0");
      $("#searchform .userlist li").css("opacity", "0");

      return false;
    }
  });

  $("#searchform .userlist li").unbind('click');
  $("#searchform .userlist li").on('click', function (e) {
    addStudent( $(this).attr('id'), true );
    e.stopPropagation();
    return false;
  });
}

function addStudent( userid, animation ) {

  var user = getUserById(userid); // renvoie les informations sur l'utilisateur concerné

  // si l'utilisateur a simplement cliqué, on signale la transition par un effet visuel
  if( animation ) {
    $("#group").addClass("ui-state-highlight");
    $("#group").addClass("drop-hover");

    setTimeout( function () {
      $("#group").removeClass("ui-state-highlight");
      $("#group").removeClass("drop-hover");
    } , 400 );
  }

  // on lance le chargement
  $("#group").addClass("load");

  // on enregistre le nouvel utilisateur
  $.ajax({
    url : "php/setAddUser.php",
    type : "post",
    data : "id=" + userid,
    dataType : "json",
    success : function(text) {

      if(text.error == 0) {

        // on suprime l'utilisateur actuel pour qu'il ne puisse pas etre recherché
        $("#searchform .userlist #" + userid).remove();
        visible.splice(visible.indexOf(userid),1);
        users.splice(users.indexOf(user),1);
        addedList.push(user);

        // on ajoute l'utilisateur au tableau du modal
        $("#class-modal .modal-body ul").append("<li id='" + user.userid + "'><span class='icon'></span><span class='username'>" + user.firstname + " " + user.lastname + "</span> - <span class='userid'>" + user.userid + "</span><i class='fa fa-close'></i></li>");
        $("#class-modal .userlist li").unbind( 'click' );
        $("#class-modal .userlist li").on('click', function (e) {
          delStudent( $(this).attr('id') );
          e.stopPropagation();
          return false;
        });

        // on ajoute 1 au nombre d'élèves dans la classe
        $("#group .nb").text(parseInt($("#group .nb").text()) + 1);

        $("#group").removeClass("load");
      } else {
        $("#group").removeClass("load");
      }

    },
    error : function(xhr) {

      console.log(xhr);
      $("#group").removeClass("load");

    }
  });

  
}

function delStudent( userid ) {

  // on lance le chargement
  $("#group").addClass("load");

  // on enlève l'utilisateur
  $.ajax({
    url : "php/setDelUser.php",
    type : "post",
    data : "id=" + userid,
    dataType : "json",
    success : function(text) {

      if(text.error == 0) {

        // on ajoute l'utilisateur actuel pour qu'il puisse etre recherché
        var user = getUserById(userid);
        if(user) {

          addedList.splice(addedList.indexOf(user),1);
          users.push(user);

        } else {

          except.push(userid);

        }

        searchUser( $("#searchbar").val() ); // on actualise la recherche

        // on suprime l'utilisateur de la classe
        $("#class-modal .userlist #" + userid).remove();

        // on enlève 1 au nombre d'élèves dans la classe
        $("#group .nb").text(parseInt($("#group .nb").text()) - 1);

        $("#group").removeClass("load");
      } else {
        console.log(text);
        $("#group").removeClass("load");
      }

    },
    error : function(xhr) {

      console.log(xhr);
      $("#group").removeClass("load");

    }
  });
}

function getUserById( userid ) {
  var re = false;

  $.each( users , function (index, value) {
    if ( value.userid == userid ) {
      re = value;
    }
  } );

  if(re == false) {
    $.each( addedList , function (index, value) {
      if ( value.userid == userid ) {
        re = value;
      }
    } );
  }

  return re;
}

function searchUser( query ) {

  updateUsers(query);

    var added = [];
    $.each( addedList, function (index, value) {
      added.push(value.userid);
    } );

    // pendant ce temps, on essaye de récupérer de nouveaux utilisateurs
    $.ajax({
      url : "php/getUsers.php",
      type : "post",
      data : "id=" + id + "&query=" + query + "&except=" + except + "&added=" + addedList,
      dataType : "json",
      success : function(text) {

        if(text.error == 0) {
          if(text.users != "") {
            $.each(text.users, function (index, value) {
              if(!getUserById(value.userid)) {
                users.push(value);
              }
            });
            updateUsers(query);
          }
        }

      },
      error : function(xhr) {

        console.log(xhr);

      }
    });

}
