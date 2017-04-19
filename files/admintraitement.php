<?php

    require __DIR__."\..\data\databaseutility.php";


        function getusers(){

            //Récupère la liste des utilisateurs dans la bdd et la renvoie sous forme d'un tableau
            $list = get_user_list();
            logger("called user list");
            foreach($list as $unit){
               // echo $unit;
                echo $unit['email']."@edu.ece.fr ". $unit['nom']." ". $unit['pseudo'] .";";
        }}

        function adduser(){

            //On récupète les informations envoyées
            $email=$_POST['emailadd'];
            $pseudo=$_POST['pseudo'];
            $nom=$_POST['nom'];
            $res = add_user($email,$nom,$pseudo);
            if($res == 1) echo "Utilisateur ajouté"; 
            else if($res == 0) echo "L'utilisateur existe déjà";
            else if($res == 2) echo "Connexion impossible";


        }

        function deleteuser(){
            //On récupète les informations envoyées
            $email=$_POST['emaildel'];   
            $res = delete_user($email);
            if($res == 1) echo "Utilisateur supprimé";
            else if($res == 0) echo "L'utilisateur n'existe pas"; 
            else if($res == 2) echo "Connexion impossible"; 
        }

        if(isset($_POST['emailadd']) && isset($_POST['pseudo']) && isset($_POST['nom'])){
            adduser();
        }
        else if(isset($_POST['emaildel'])){
            deleteuser();
        }
        else{
            getusers();
        }

        /*

        //Insert query
        $query = mysql_query("insert into form_element(name, email, password, contact) values ('$name2', '$email2', '$password2','$contact2')");
        echo "Form Submitted Succesfully";

        */

