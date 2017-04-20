<?php
/**
 * Created by PhpStorm.
 * User: essen
 * Date: 4/15/17
 * Time: 11:48 AM
 */
require_once "settingspath.php";
require_once "filemanger.php";
require_once __DIR__ . SLASH."..".SLASH."log".SLASH."looger.php";
require_once "connection.php";

function get_email($prefix){
    $ret = $prefix . "@edu.ece.fr";
    return $ret;
}
function get_friend_status($row){
    if($row["status"]==1){
        return "Amis depuis le ".$row["date"];
    }
    else {
        if($row["user1"] == $_COOKIE['user']){
            return "Vous avez demandé en ami ".get_email($row["user2"])." le ".$row["date"];
        }
        else return get_email($row["user1"])." a demandé en ami ".get_email($row["user2"])." le ".$row["date"];
    }
}

/*
 * Permet de recuperer les emails des amies du l'utilisateur dont l'id est passer en argument
 */
function friend_list($friend_status){
    $data_out = [];
    $data =[];
    $db = connect_db();
    if($db->ping()){
        $email = get_cookie_name();
        logger("valheur du cookie ".$email);
        $sql = "SELECT * FROM webapp.amis WHERE ( user1='$email' OR user2='$email')" ;
        $res = mysqli_query($db,$sql);
        for ($i = 0; $i < mysqli_num_rows($res); $i++) {
            $data[$i] = mysqli_fetch_assoc($res);
            if($data[$i]['user1']==$email){
                $friend = $data[$i]['user2'];
            }else{
                $friend = $data[$i]['user1'];
            }logger("friend found ".$friend);
            $data_out[$i] = get_selected_user($friend);
            if($friend_status){$data_out[$i]['friend_status'] = get_friend_status($data[$i]);}

        }

    }else{
        logger("erreur de connection a la base ");
    }
    return $data_out;
   /*echo "<br> <h6> Acriviter de la liste d'ami </h6> <h5><ul>";
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
    echo "</h5> </ul>";*/
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

function get_user(){
    $db = connect_db();
    $email = get_cookie_name();
    $res = [];
    if(isset($_COOKIE['user'])) {
        //ceci est une diff
        if ($db->ping()) {

            $sql = "SELECT * FROM webapp.user WHERE email='$email'";
            $resrequette = mysqli_query($db, $sql);

            $res = mysqli_fetch_assoc($resrequette);
        }
    }else{
        logger("erreur de cookie retrive");
    }
    return $res;
}
function get_selected_user($email){
    $db = connect_db();
    $res = [];
        //ceci est une diff
        if ($db->ping()) {

            $sql = "SELECT * FROM webapp.user WHERE email='$email'";
            $resrequette = mysqli_query($db, $sql);

            $res = mysqli_fetch_assoc($resrequette);
        }

    return $res;
}
function get_ellements_in_album($db,$user,$idalbum){
    $res =[];
    $sql = "SELECT * FROM webapp.post WHERE user='$user' AND idalbum='$idalbum' ";
    $resrequette = mysqli_query($db, $sql);

    for ($i = 0; $i < mysqli_num_rows($resrequette); $i++) {
        $res[$i] = mysqli_fetch_assoc($resrequette);
    }logger("nous avons trouver ".mysqli_num_rows($resrequette)."post pour l'album ".$idalbum);
    return $res;
}
function get_album(){
    $db = connect_db();
    $email = get_cookie_name();
    $res = [];
    //ceci est une diff
    if($db->ping()) {

        $sql = "SELECT * FROM webapp.album WHERE user='$email'";
        $resrequette = mysqli_query($db, $sql);

        for ($i = 0; $i < mysqli_num_rows($resrequette); $i++) {
            $res[$i] = mysqli_fetch_assoc($resrequette);
            $res[$i]['post'] = get_ellements_in_album($db,$email,$res[$i]['id']);
        }
    }
    if($res)
    {
        return $res;
    }
    else return 2;

}
function get_photos_albums($album){
    $db = connect_db();
    $email = $_COOKIE['user'];
    $res = [];
    //ceci est une diff
    if($db->ping()) {

        $sql = "SELECT * FROM webapp.post WHERE idpost='$album'";
        $resrequette = mysqli_query($db, $sql);

        for ($i = 0; $i < mysqli_num_rows($resrequette); $i++) {
            $res[$i] = mysqli_fetch_assoc($resrequette);
        }
    }
    if($res)
    {
        return $res;
    }
    else return 2;
}
/*
 * Verfie si l'utilisateur existe deja dans la base et essaye de l'ajouter, return :
 * 0 - fail , l'utilisateur existe deja
 * 1 - succes , ajout reussie
 * 2 - fail , impossible dde se connecter à la BDD
 */
function add_user($email,$nom,$pseudo){
    $db = connect_db();
    $sql = "INSERT INTO webapp.user (email, nom, mdp, pseudo) VALUES ('$email','$nom','$pseudo','$pseudo')";
    if ($db->ping()) {
        if(mysqli_query($db,$sql)){
            //creation reussi
            creat_new_user_directory($email);
            logger("succes - creation de l'utilisateur avec les parametres :".$email.$nom.$pseudo);
            return 1;
        }
        else{
            logger("erreur - creation de l'utilisateur avec les parametres :".$email.$nom.$pseudo);
            return 0;
        } 
    }
    else{
        return 2;
    } // erreur dans la creation
}
/*
 * Verfie si l'utilisateur existe deja dans la base et le supprime de la base, return :
 * 0 - fail , n'existe pas
 * 1 - sucees , effeceage de la surface du web reussi
 * 2 - fail, connexion impossible
 */
function delete_user($email)
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
            return 1;
        }else {
            logger("Erreur - l'utilisateur n'existe pas , impossible de le suprimer ".$email);
            return 0;
        }
    }return 2;
}
/*
 * Demande en amie :
 * 0 - erreur cette demande a deja etait faite
 * 1 - sucees
 * fonctionne
 */
function friend_request($touser){
    $db = connect_db();
    $mytmpuser = get_cookie_name();
    if($db->ping()) {
        if (isset($_COOKIE['user'])){
            if($touser != $_COOKIE['user']){
                $fromuser = $_COOKIE['user'];
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

                        return 2;
                    }
                }
            }else return 3;
        }else{
            logger("erreur de cookie de sesion");
            return 4;
        }
    }
}
/*
 * accepter une demande en amie d'un utilisateur:
 * l'utilisateur qui accept la demande est touser le recepteur de la demande
 */
function accept_friend_request($fromuser){
    $touser =get_cookie_name();
    $db = connect_db();
    if($db->ping()){
        if(isset($_COOKIE['user'])){
            $sql = "SELECT * FROM webapp.amis WHERE (user1='$fromuser' AND user2='$touser') OR (user1='$touser' AND user2='$fromuser') AND status=0";
            $res = mysqli_query($db,$sql);
            if (mysqli_num_rows($res) == 1) {
                $sql = "UPDATE webapp.amis SET status=1 , date=now() WHERE (user1='$fromuser' AND user2='$touser') OR (user1='$touser' AND user2='$fromuser') AND amis.status=0";
                if(mysqli_query($db,$sql)){
                    //creation reussi
                    logger("succes - update accept la demande d'amie avec les parametres :".$fromuser. " ".$touser." 1 ");
                    return 1;
                }else {
                    logger("erreur - update accept la demande d'amie avec les parametres :".$fromuser. " ".$touser." 1 ");
                    return 0;
                }
            }else {
                logger("error , nombre de ligne invalide");
                return 2;
            }

        }else{
            logger("erreur de cookie de sesion");
            return 3;
        }
    }else return 4;
}
/*
 * Fonction pour cree un nouveau post , type de postes :
 *  0 - post ecrit : le text sera stoquer dans legende
 *  1 - photo : il peut y avoir une legende et un idalbum ( pas obligatoire pour les deux) - $contenu a la path vers le fichier selectionner par l'utilisateur
 *  2 - video : meme que photo
 */
function delet_friend($todelet,$status){
    $touser = get_cookie_name();
    $db = connect_db();
    if($db->ping()){
        if(isset($_COOKIE['user'])){
            $sql= "DELETE FROM webapp.amis WHERE (user1='$todelet' AND user2='$touser') OR (user2='$todelet' AND user1='$touser')" ;
            if(mysqli_query($db,$sql)){
                logger("Destruction de l'ami");
                return 1;
            }
           else{
               logger("erreur dans la destruction de l'ami");
               return 0;
           }
        }else{
            logger("erreur de cookie de session");
            return 2;
        }
    }else{
        logger("erreur connexion base de donnée");
        return 3;
    }
}

/*
 * Procedure de l'utilisateur avec email et pw , verifie que ce sont les bons identifiants
 * 0 - connection reussi
 * 1 - utilisateur n'existe pas
 * 2 - mauvais mot de passe
 * 3 - erreur bd
 */
function connect_datavalide($email,$pw){
    $db = connect_db();
    if($db->ping()) {
        $sql = "SELECT * from webapp.user WHERE email='$email' ";
        $res = mysqli_query($db,$sql);
        if($res){
            $row = mysqli_fetch_assoc($res);
            if ( $row['mdp']==$pw){
    //            logger("Connection reussi pour l'utilisatuer , user : ".$email." mdp : ".$pw);
                return 0;
            }else{
      //          logger("Erreur - mauvais mot de passe pour user: ".$email);
                return 2;
            }
        }else{
        //    logger("Erreur - identifiant de l'utilisatuer n'existe pas utilisateur : ".$email);
            return 1;
        }
    }else{
        return 3;
    }
}

/*
 * Change le nom de l'utilisateur
 * 0 - nom changé
 * 1 - utilisateur n'existe pas
 * 2 - connexion impossible
 */
function change_name($name){
    $db = connect_db();
    if($db->ping()) {
        $email = get_cookie_name();
        if($email !=''){
            $sql = "UPDATE webapp.user SET nom = '$name' WHERE email='$email' ";
            if (mysqli_query($db, $sql)) {
                //"Record updated successfully";
                return 0;
            }
            else return 1;
        
        } else {
            //"Mise à jour impossible";
            return 1;
        }
    }else{
        return 2;
    }
}

/*
 * Change le pseudo de l'utilisateur
 * 0 - pseudo changé
 * 1 - utilisateur n'existe pas
 * 2 - connexion impossible
 */
function change_pseudo($change){
    $db = connect_db();
    if($db->ping()) {
        $email = get_cookie_name();
        if($email !=''){
            $sql = "UPDATE webapp.user SET pseudo = '$change' WHERE email='$email' ";
            if (mysqli_query($db, $sql)) {
                //"Record updated successfully";
                return 0;
            }
            else return 0;
        } else {
            //"Mise à jour impossible";
            return 1;
        }
    }else{
        return 2;
    }
}

/*
 * Change le password de l'utilisateur
 * 0 - mdp changé
 * 1 - Mise à jour impossible
 * 2 - connexion impossible
 * 3 - mauvais ancien mot de passe
 */
function change_pwd($ancien, $nouveau){
    $db = connect_db();
    if($db->ping()) {
        $email = get_cookie_name();
        if($email !=''){

            $sql = "SELECT mdp FROM webapp.user WHERE email='$email' limit 1";
            $resrequette = mysqli_query($db, $sql);

            if(mysqli_num_rows($resrequette)) {
                $res = mysqli_fetch_assoc($resrequette);

            if($res['mdp'] == $ancien){
                $sql = "UPDATE webapp.user SET mdp = '$nouveau' WHERE email='$email' limit 1";

                if (mysqli_query($db, $sql)) {
                //"Record updated successfully";
                return 0;
                } else {
                    //"Mise à jour impossible";
                    return 1;
                }
            }return 3;}
            else return 3;
        }
        else return 1;  
    }
    else return 2;
}
