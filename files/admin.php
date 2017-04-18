<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"> </script>
        <script type="text/javascript" src="admin.js"></script>

        <title>Admin</title>
    </head>
   
    <body>
 
        <input type="button" id="ajouterButton" value="Ajouter un utilisateur"/>
 
        <form class="hidden ajouter" method="post" id="ajouterAction">
            Email : <input type="text" name="emailadd" id="emailadd"/> @edu.ece.fr         
            Pseudo : <input type="text" name="pseudo" id="pseudo"/>
            Nom : <input type="text" name="nom" id="nom"/>
            <input type="submit" value="Valider"/>
        </form>
       
        <input type="button" id="supprimerButton" value="Supprimer un utilisateur"/>
 
        <form class="hidden supprimer" id="supprimerAction" method="post">
            Email : <input type="text" name="emaildel" id="emaildel"/> @edu.ece.fr 
            <input type="submit" value="Valider"/>
        </form>
        
        <div id="userlist">
        
        </div>
    </body>
</html>