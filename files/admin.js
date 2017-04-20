$(document).ready(function () {

    //on cache les formulaires
    $(".supprimer").hide();
    $(".ajouter").hide();

    var i;
    function afficheusers() {
        //Affiche la liste des utilisateurs
        $.ajax({
            url: 'admintraitement.php',
            method: 'GET',
            success: function (msg) {
                var users = msg.split(";");
                $.each(users, function ( index, value ){
                    if(index == 0) $('#userlist').html("<li>" +value +"</li><br/>");

                    else $('#userlist').append("<li>" +value +"</li><br/>");
                });

            }
        });
     };

    afficheusers();

    //Affiche le champ pour rentrer les infos de l'utilisateur à ajouter
    $("#ajouterButton").click(function () {
        $(".supprimer").hide();
        $(".ajouter").show();
    });

    //Affiche le champ pour rentrer les infos de l'utilisateur à supprimer
    $("#supprimerButton").click(function () {
        $(".ajouter").hide();
        $(".supprimer").show();
    });

    //Si on clique sur le bouton d'ajout
    $("#ajouterAction").submit(function (e) {
        e.preventDefault();
        if ($("#emailadd").val() == ''||$("#pseudo").val()==''||$("#nom").val()=='')
        {
            alert("Veuillez remplir tous les champs pour créer un nouvel utilisateur");
        }
        else if($("#emailadd").val().lastIndexOf("@") != -1){
            alert("Veuillez entrer une adresse mail valide");
        }
        else{
            $.ajax({
                data: 'emailadd=' +  $("#emailadd").val() + '&pseudo=' + $("#pseudo").val() + '&nom=' + $("#nom").val() ,
                url: 'admintraitement.php',
                method: 'POST',
                success: function(msg) {
                    alert(msg);
                    afficheusers();
                }
            });
        }
    });

    //Si on clique sur le bouton d'ajout
    $("#supprimerAction").submit(function(e){
        e.preventDefault();
        if($("#emaildel").val() =='')
        {
            alert("Veuillez entrer l'email pour supprimer un utilisateur");
        }
        else if($("#emaildel").val().lastIndexOf("@") != -1){
            alert("Veuillez entrer une adresse mail valide");
        }
        else{
            $.ajax({
                data: 'emaildel=' +  $("#emaildel").val(),
                url: 'admintraitement.php',
                method: 'POST',
                success: function(msg) {
                    alert(msg);
                    afficheusers();
                }
            });
        }
    });

});