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
                for (i = 0; i < users.length; i++) {
                    $temp = $users[i].split("-");
                    $.each(temp, function ( index, value ){
                        if(i==0)
                            $('#userlist').html("<img src={{ '/../userdata/'"+ temp[0] +"'/icon.png'}} alt=&quot;Icon&quot; height=&quot;128&quot; width=&quot;128&quot;>"+ temp[1] +"<br/>");

                        else $('#userlist').append("<img src={{ '/../userdata/'"+ temp[0] +"'/icon.png'}} alt=&quot;Icon&quot; height=&quot;128&quot; width=&quot;128&quot;>"+ temp[1] +"<br/>");
                    }); 
                }
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