<?php
//use \Psr\Http\Message\ServerRequestInterface as Request;
//use \Psr\Http\Message\ResponseInterface as Response;
require "settingspath_root.php";
require "vendor".SLASH."autoload.php";
require_once "data".SLASH."databaseutility.php";
require "data".SLASH."cookiemonster.php";

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

  connect("m.champalier","ooo");
  //TODO revoyer les paramtres de connection effectif, a faire quand on aura une page de connection
  return "m.champalier";
};
$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "Publication.twig","user_name" => $this->username]);
});
$app->get('/Coupe2016/', function ($request, $response, $args) {
    accept_friend_request($this->db,"desmazes","kiki");
    $data = get_user_list($this->db);
    return $this->view->render($response, 'UserTest.twig', ["users" => $data]);
});
$app->get('/Configuration/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "Configuration.twig"]);
});
$app->get('/Publication/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "Publication.twig" ,"user_name" =>$this->username]);
});
$app->run();