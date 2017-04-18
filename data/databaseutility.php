<?php
/**
 * Created by PhpStorm.
 * User: essen
 * Date: 4/15/17
 * Time: 11:48 AM
 */

require "filemanger.php";
require __DIR__."/../log/looger.php";
require "connection.php";

function get_email($prefix){
    $ret = $prefix . "@edu.ece.fr";
    return $ret;
}
function get_friend_status($row){
    if($row["status"]==1){
        return "L'utilisateur ".get_email($row["user1"])." et ".get_email($row["user2"])." sont ami depuis le ".$row["date"]." <br>";
    }
    else return "L'utilisateur ".get_email($row["user1"])." a demander en amis ".get_email($row["user2"])." le ".$row["date"]." <br>";
}
/*
 * Permet de recuperer les emails des amies du l'utilisateur dont l'id est passer en argument
 */
function friend_list($userid,$db){
    echo "<br> <h6> Acriviter de la liste d'ami </h6> <h5><ul>";
    $sqlquery = "SELECT * FROM webapp.amis  WHERE user1='$userid'  OR user2='$userid' ";
    $res = mysqli_query($db,$sqlquery);
    if (mysqli_num_rows($res) > 0) {
        // output data of each row

        while($row = mysqli_fetch_assoc($res)) {
            echo "<li>".get_friend_status($row)."</li>";
              }
    } else {
        echo "<li>0 results</li>";
    }
    echo "</h5> </ul>";
}
function get_user_list(){
    $db = connect_db();
    $res = [];
    //ceci est une diff
    if($db->ping()) {

        $sql = "SELECT * FROM webapp.user";
        $resrequette = mysqli_query($db, $sql);
        for ($i = 0; $i < mysqli_num_rows($resrequette); $i++) {
            $res[$i] = mysqli_fetch_assoc($resrequette);
        }

    }
    return $res;
}
/*
 * Verfie si l'utilisateur existe deja dans la base et essaye de l'ajouter, return :
 * 0 - fail , l'utilisateur existe deja
 * 1 - sucees , ajout reussie
 */
function add_user($bd,$email,$nom,$pseudo){
    $sql = "INSERT INTO webapp.user (email, nom, mdp, pseudo) VALUES ('$email','$nom','$pseudo','$pseudo')";
    if(mysqli_query($bd,$sql)){
        //creation reussi
        creat_new_user_directory($email);
        logger("sucees - creation de l'utilisateur avec les parapetres :".$email.$nom.$pseudo);

        return 1;
    }
    else{
        logger("erreur - creation de l'utilisateur avec les parapetres :".$email.$nom.$pseudo);

        return 0;
    } // erreur dans la creation
}
/*
 * Verfie si l'utilisateur existe deja dans la base et le supprime de la base, return :
 * 0 - fail , n'existe pas
 * 1 - sucees , effeceage de la surface du web reussi
 */
function delet_user($email)
{
    $bd = connect_db();
    if ($bd->ping()) {
        //blindage - verification que l'utilisateur existe
        $sql = "SELECT * from webapp.user WHERE email='$email'";
        $res = mysqli_query($bd,$sql);
        if (mysqli_num_rows($res) > 0) {
            //destruction de l'utilisateur de la base de donner
            $sql = "DELETE FROM webapp.reaction WHERE user='$email' ";
            if (mysqli_query($bd, $sql)) {
                logger("suces - destruction des reaction de l'utilisateur " . $email);
            } else {
                logger("echeque - destruction des reaction de l'utilisateur " . $email);
            }
            $sql = "DELETE FROM webapp.post WHERE user='$email' ";
            if (mysqli_query($bd, $sql)) {
                logger("suces - destruction des posts de l'utilisateur " . $email);
            } else {
                logger("echeque - destruction des post de l'utilisateur " . $email);
            }
            $sql = "DELETE FROM webapp.album WHERE user='$email' ";
            if (mysqli_query($bd, $sql)) {
                logger("suces - destruction des album de l'utilisateur " . $email);
            } else {
                logger("echeque - destruction des album de l'utilisateur " . $email);
            }
            $sql = "DELETE FROM webapp.amis WHERE user1='$email' OR user2='$email' ";
            if (mysqli_query($bd, $sql)) {
                logger("suces - destruction des relations d'amie de l'utilisateur " . $email);
            } else {
                logger("echeque - destruction des relations d'amie de l'utilisateur " . $email);
            }
            $sql = "DELETE FROM webapp.user WHERE email='$email' ";
            if (mysqli_query($bd, $sql)) {
                logger("suces - destruction de l'utilisateur " . $email);
            } else {
                logger("echeque - destruction de l'utilisateur " . $email);
            }
            //suppression de ces donners
            rrmdir("userdata/".$email);
        }else {
            logger("Erreur - l'utilisateur n'existe pas , pas possible de le suprimer ".$email);
        }
    }return 0;
}
/*
 * Demande en amie :
 * 0 - erreur cette demande a deja etait faite
 * 1 - sucees
 * fonctionne
 */
function friend_request($db,$fromuser,$touser){
    $sql = "SELECT * FROM webapp.amis WHERE user1='$fromuser' AND user2='$touser' 
            OR user2='$fromuser' AND user1='$touser' ";
    $res = mysqli_query($db,$sql);
    if (mysqli_num_rows($res) > 0) {
        logger("Erreur une relation d'amie existe deja entre ".$fromuser." et ".$touser);
        return 0;
    }
    else{
        $sql = "INSERT INTO webapp.amis (user1, user2,status,date) VALUES ('$fromuser','$touser',0,now())";
        if(mysqli_query($db,$sql)){
            //creation reussi
            logger("sucees - creation de une demande d'amie avec les parametres :".$fromuser. " ".$touser." 0 ");

            return 1;
        }else {
            logger("erreur - creation de une demande d'amie avec les parametres :".$fromuser. " ".$touser." 0 ");

            return 0;
        }
    }
}
/*
 * accepter une demande en amie d'un utilisateur:
 * l'utilisateur qui accept la demande est touser le recepteur de la demande
 */
function accept_friend_request($db,$fromuser,$touser){
    $sql = "SELECT * FROM webapp.amis WHERE user1='$fromuser' AND user2='$touser' AND amis.status=0";
    $res = mysqli_query($db,$sql);
    if (mysqli_num_rows($res) == 1) {
        $sql = "UPDATE webapp.amis SET status=1 , date=now() WHERE user1='$fromuser' AND user2='$touser' AND amis.status=0";
        if(mysqli_query($db,$sql)){
            //creation reussi
            logger("sucees - update accept la demande d'amie avec les parametres :".$fromuser. " ".$touser." 1 ");
        }else {
            logger("erreur - update accept la demande d'amie avec les parametres :".$fromuser. " ".$touser." 1 ");
        }
    }else {logger("error , nombre de ligne invalide");}
}
/*
 * Fonction pour cree un nouveau post , type de postes :
 *  0 - post ecrit : le text sera stoquer dans legende
 *  1 - photo : il peut y avoir une legende et un idalbum ( pas obligatoire pour les deux) - $contenu a la path vers le fichier selectionner par l'utilisateur
 *  2 - video : meme que photo
 */
function create_post($db,$email,$typepost,$legende,$idalbum,$contenu){
    //blindage
    $sql ="";
    $db = connect_db();
    if($db->ping()) {
        if ($typepost >= 0 and $typepost < 3) {
            switch ($typepost) {
                case 0:
                    $sql = "INSERT INTO webapp.post (user, type, legende)  VALUES ('$email','$typepost','$legende')";
                    break;
                case 1 && 2:
                    if ($idalbum != 0) $sql = "INSERT INTO webapp.post (user, type, legende,idalbum)  VALUES ('$email','$typepost','$legende','$idalbum')";
                    else $sql = "INSERT INTO webapp.post (user, type, legende)  VALUES ('$email','$typepost','$legende')";
                    break;
            }
            $sql .= " WHERE user='$email' ";
            $res = mysqli_query($db, $sql);
            if ($res) {
                //creation reussi

                $row = mysqli_fetch_assoc($res);
                $idpost = $row["idpost"];
                if ($typepost > 0) {
                    //TODO sauvgarde de la photo ou video poster dans le dossier adequa
                    if (save_post($idpost, $idalbum, $contenu)) {
                        logger("sucees - creation d'un post pour l'utilisateur " . $email);
                    } else logger("erreur - creation d'un post pour l'utilisateur " . $email);
                }
            } else {
                logger("erreur - creation d'un post pour l'utilisateur " . $email);
            }
        } else {
            logger("erreur dans le type du post, type donner :" . $typepost);
        }
    }
}
/*
 * Procedure de l'utilisateur avec email et pw , verifie que ce sont les bons identifiants
 * 0 - connection reussi
 * 1 - utilisateur n'existe pas
 * 2 - mauvais mot de passe
 */
function connect_datavalide($email,$pw){
    $db = connect_db();
    if($db->ping()) {
        $sql = "SELECT * from webapp.user WHERE email='$email' ";
        $res = mysqli_query($db,$sql);
        if($res){
            $row = mysqli_fetch_assoc($res);
            if ( $row['mdp']==$pw){
                logger("Connection reussi pour l'utilisatuer , user : ".$email." mdp : ".$pw);
                return 0;
            }else{
                logger("Erreur - mauvais mot de passe pour user: ".$email);
                return 2;
            }
        }else{
            logger("Erreur - identifiant de l'utilisatuer n'existe pas utilisateur : ".$email);
            return 1;
        }
    }
}
