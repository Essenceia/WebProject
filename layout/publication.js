$(document).ready(function () {
    $("#buttonStatuts").submit(function(){
    var dateBox=-'', statutBox='', lieuBox='', emo='', act='', pap='';
        if($("#status").val()!=''){
            if($("#lieu").val()!='lieu'){ lieuBox= $("#lieu").val();}
            if($("#emotion").val()!='emotion'){ emo= $("#emotion").val();}
            if($("#activite").val()!='activite'){ act= $("#activite").val();}

            if(document.getElementById('pu').checked){pap=0;}
            if(document.getElementById('am').checked){pap=1;}
            if(document.getElementById('pr').checked){pap=2;}

            $ajax({
                data: 'type='+0+ '&legende=' +  $("#status").val() + '&idalbum=NULL &lieu=' + lieuBox + '&emotion='+emo +'&activite='+ act + '&contenu=NULL &pap='+pap ,
                url: 'publication.php',
                method: 'GET',
            })
        }
        else alert("Vous n'avez rien entré!");

    })
    //on cache les formulaires
   // $(".supprimer").hide();
    //$(".ajouter").hide();
    
    //var i;
    /*function afficheusers() {
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
     };*/
    
   /* afficheusers();
    
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
    });*/
});