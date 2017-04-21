<?php
//use \Psr\Http\Message\ServerRequestInterface as Request;
//use \Psr\Http\Message\ResponseInterface as Response;
require_once "settingspath_root.php";
require_once "vendor".SLASH."autoload.php";
require_once "data".SLASH."databaseutility.php";
require_once "data".SLASH."cookiemonster.php";
require_once "data".SLASH."postutility.php";
$app = new \Slim\App([
    'settings' => [
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        ]]);
// Get container
$container = $app->getContainer();
// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('layout', [
    ]);
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    return $view;
};
$container['db']= function(){
    $db = connect_db();
    return $db;
};
/*
$container['username']= function (){
  $email = "m.champalier";
  $mdp = 'ooo';
  connect($email,$mdp);
  //TODO revoyer les paramtres de connection effectif, a faire quand on aura une page de connection
  return  $email;
};*/
//disconnect();
$app->get('/Login/', function ($request, $response, $args) {
    disconnect();
    return $this->view->render($response, 'login.twig');
});
$app->get('/', function ($request, $response, $args) {
    disconnect();
    return $this->view->render($response, 'login.twig');
});
$app->get('/Profil/', function ($request, $response, $args) {
    $data = get_user();
    $user = get_cookie_name();
    $res =[];
    return $this->view->render($response, 'index.twig', ["user" => $data, "name" => "profil.twig", "data"=>$res]);
    //return $this->view->render($response, 'index.twig', ["name" => "Publication.twig"]);
});
$app->get('/Album/', function ($request, $response, $args) {
    //accept_friend_request($this->db,"desmazes","kiki");
    $user = get_cookie_name();
    $data = get_album();
    $tmp = [];
    if($data==2)
    {
        return $this->view->render($response, 'index.twig', ["album" => $data, "name" => "album.twig", "error"=> "Il n'y a aucun album" , "data"=>$tmp]);

    }
    else return $this->view->render($response, 'index.twig', ["album" => $data, "name" => "album.twig", "error"=> "", "data"=>$tmp]);

});

$app->get('/Photos/', function ($request, $response, $args) {
    //accept_friend_request($this->db,"desmazes","kiki");
    $user = get_cookie_name();
    $data = get_album();


    $tmp = [];

    if($data==2)
    {
        return $this->view->render($response, 'index.twig', ["album" => $data, "name" => "album.twig", "error"=> "Il n'y a aucun album" , "data"=>$tmp]);

    }
    else return $this->view->render($response, 'index.twig', ["album" => $data, "name" => "album.twig", "error"=> "", "data"=>$tmp]);

});

$app->get('/Coupe2016/', function ($request, $response, $args) {
    $user = get_cookie_name();
    accept_friend_request($this->db,"desmazes","kiki");
    //$data = get_user_list($this->db);
    $data = get_user_list();

    return $this->view->render($response, 'UserTest.twig', ["users" => $data]);

    $res = [];
    return $this->view->render($response, 'UserTest.twig', ["users" => $data,"data" =>$res]);

});

$app->get('/Configuration/', function ($request, $response, $args) {
    $res =[];
    $user = get_cookie_name();
    return $this->view->render($response, 'index.twig', ["name" => "Configuration.twig","data" =>$res]);
});
$app->get('/Chronologie/', function ($request, $response, $args) {
    $user = get_cookie_name();
    $data['chrono'] = get_chronologie(0);
    $data['alb'] = get_album();
    return $this->view->render($response, 'index.twig', ["name" => "chronologie.twig", "data" => $data]);
});
$app->get('/Publication/', function ($request, $response, $args) {
    $name = get_cookie_name();
    $data = [];
    $data['post'] = get_post_actualiter(0,$name);
    $data['album'] = get_album();
    return $this->view->render($response, 'index.twig', ["name" => "Publication.twig" ,"user_name" =>$name , "data" => $data]);
});
$app->get('/Amis/', function ($request, $response, $args) {
    $user = get_cookie_name();
    logger("friend_list still called");
    $data = friend_list(1);
    $name = get_cookie_name();
    logger("end friend_list still called");
    return $this->view->render($response, 'index.twig', ["name" => "amis.twig" ,"user_name" =>$name, "data" => $data]);
});
$app->run();