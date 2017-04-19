<?php
//use \Psr\Http\Message\ServerRequestInterface as Request;
//use \Psr\Http\Message\ResponseInterface as Response;
require "settingspath_root.php";
require "vendor".SLASH."autoload.php";
require_once "data".SLASH."databaseutility.php";
require "data".SLASH."cookiemonster.php";
require "data".SLASH."postutility.php";
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

$container['username']= function (){
  $email = "m.champalier";
  $mdp = 'ooo';
  connect($email,$mdp);
  //TODO revoyer les paramtres de connection effectif, a faire quand on aura une page de connection
  return  $email;
};
$app->get('/Login', function ($request, $response, $args) {
    return $this->view->render($response, 'login.twig');
});
$app->get('/Profil/', function ($request, $response, $args) {
    $data = get_user($this->username);
    return $this->view->render($response, 'index.twig', ["user" => $data, "name" => "profil.twig"]);
    //return $this->view->render($response, 'index.twig', ["name" => "Publication.twig"]);
});
$app->get('/Album/', function ($request, $response, $args) {
    //accept_friend_request($this->db,"desmazes","kiki");
    $data = get_album($this->username);
    if($data==2)
    {
        return $this->view->render($response, 'index.twig', ["album" => $data, "name" => "album.twig", "error"=> "Il n'y a aucun album"]);

    }
    else return $this->view->render($response, 'index.twig', ["album" => $data, "name" => "album.twig", "error"=> ""]);

});
$app->get('/Coupe2016/', function ($request, $response, $args) {
    accept_friend_request($this->db,"desmazes","kiki");
    $data = get_user_list($this->db);
    return $this->view->render($response, 'UserTest.twig', ["users" => $data]);
});

$app->get('/Configuration/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "Configuration.twig"]);
});
$app->get('/Chronologie/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "chronologie.twig"]);
});
$app->get('/Publication/', function ($request, $response, $args) {
    $data = get_post_actualiter(0,$this->username);
    return $this->view->render($response, 'index.twig', ["name" => "Publication.twig" ,"user_name" =>$this->username , "data" => $data]);
});
$app->get('/', function ($request, $response, $args) {
    logger("friend_list still called");
    $data = friend_list(1);
    logger("end friend_list still called");
    return $this->view->render($response, 'index.twig', ["name" => "Amis.twig" ,"user_name" =>$this->username , "data" => $data]);
});
$app->run();