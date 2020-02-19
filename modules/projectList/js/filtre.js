$(document).ready(function(){
    $('.dropdown-trigger').dropdown();
    var myId = document.getElementById('promo');
    let data;
    if(myId == null){
        nom(undefined);// permet d'afficher toute la liste. car l'étudiant n'as pas l'id pour le filtre car il n'est pas autorisé à filtrer
    }
    else {
        nom(myId.value);
        var promo = document.getElementById('promo');
        promo.addEventListener("change", function (e) { // lors du changement de selection, on récupère la valeur et on envoie à la fonction ajax
            data = {
                'promo': document.getElementById('promo').value,
            };
            $("#activite").css("display","block");
            $("#activite").val(5);
            nom(data);
            var activite = document.getElementById('activite');
            activite.addEventListener("change", function (e) {
                data["actif"] = activite.value;
                nom(data);
            });
            /*form.submit();*/
        });
    }
});