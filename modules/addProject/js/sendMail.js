function sendMail (data){
    $.ajax({
        url : "./php/sendMail.php",
        type : 'post',
        // on envoi l'identifiant de la session PHP et la demande de sauvegarde du cookie en POST
        data : "titre=" + data["titre"] + "&promotion=" + data["promotion"],
        // on s'attend à récupérer des données structurées en json
        dataType : 'json',
        // si la réception s'effectue sans problèmes, on redirige l'utilisateur vers le menu
        success : function(text) {
            if(text.error != 0) {
                alert(text.error);
            }
        },
        error : function(xhr) {
            alert("error : "+xhr.error);
        }
    });
}