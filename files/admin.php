<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"> </script>
        <script type="text/javascript" src="admin.js"></script>

        <title>Admin</title>
        <script>

            function getCookie(cname) {
                var name = cname + "=";
                var decodedCookie = decodeURIComponent(document.cookie);
                var ca = decodedCookie.split(';');
                for(var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }
            function checkCookie() {

                var user=getCookie("admin");
                //alert(user);
                if (user.valueOf() != "true") {
                   // alert("Not an admin");
                    $( "#admin_block" ).hide();
                    $("#not_admin").show();

                }else{
                    //alert("You are an admin");

                    $( "#admin_block" ).show();
                    $("#not_admin").hide();
                }
            }

        </script>
    </head>
   
    <body onload="checkCookie()">
    <div id="not_admin">
        Erreur - Tu n'est pas un admin
        <br>
        <form action="http://localhost:8080/">
            <input type="submit" value="Retour au login" />
        </form>
    </div>
 <div id="admin_block"  >
        <input type="button" id="ajouterButton" value="Ajouter un utilisateur"/>
 
        <form class="hidden ajouter" method="post" id="ajouterAction">
            Email : <input type="text" name="emailadd" id="emailadd"/> @edu.ece.fr         
            Pseudo : <input type="text" name="pseudo" id="pseudo"/>
            Nom : <input type="text" name="nom" id="nom"/>
            <input type="submit" value="Valider"/>
        </form>
       
        <input type="button" id="supprimerButton" value="Supprimer un utilisateur"/>
 
        <form class="hidden supprimer" id="supprimerAction" >
            Email : <input type="text" name="emaildel" id="emaildel"/> @edu.ece.fr 
            <input type="submit" value="Valider"/>
        </form>
        
        <div>
            <h2>Liste des utilisateurs</h2>
            <div>
                <ul id="userlist">
                
                </ul>
            </div>
        </div>
 </div>
    </body>
</html>