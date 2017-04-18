<?php

    require __DIR__."\..\data\databaseutility.php";

    $db = connect_db();

    if(!$db)
        echo "Impossible de se connecter";
    else{
        function getusers(){
            //Récupère la liste des utilisateurs dans la bdd et la renvoie sous forme d'un tableau
            $list = get_user_list($db);
            foreach($list as $unit)
                echo $unit;
                // echo $unit['email'] +" "+ $unit['nom'] +" "+ $unit['pseudo'] +";";
        }

        function adduser(){

            //On récupète les informations envoyées
            $email=$_POST['emailadd'];
            $pseudo=$_POST['pseudo'];
            $nom=$_POST['nom'];

            echo "Utilisateur ajouté";    

        }

        function deleteuser(){
            //On récupète les informations envoyées
            $email=$_POST['emaildel'];   
            echo "Utilisateur supprimé";  
        }

        if(isset($_POST['emailadd']) && isset($_POST['pseudo']) && isset($_POST['nom'])){
            adduser();
        }
        else if(isset($_POST['emaildel'])){
            deleteuser();
        }
        else getusers();

        /*

        //Insert query
        $query = mysql_query("insert into form_element(name, email, password, contact) values ('$name2', '$email2', '$password2','$contact2')");
        echo "Form Submitted Succesfully";

        */
    }
?>