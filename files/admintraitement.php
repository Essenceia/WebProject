<?php

    function getusers(){
        //Récupère la liste des utilisateurs dans la bdd et la renvoie sous forme d'un tableau
        
    }

    function adduser(){

        //On récupète les informations envoyées
        $email=$_POST['emailadd'];
        $pseudo=$_POST['pseudo'];
        $nom=$_POST['nom'];
       
        echo "donnée reçue";    

    }

    function deleteuser(){
        //On récupète les informations envoyées
        $email=$_POST['emaildel'];   
        echo "donnée reçue";  
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


?>