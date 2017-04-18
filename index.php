<?php
//use \Psr\Http\Message\ServerRequestInterface as Request;
//use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor\autoload.php';
require_once'data\databaseutility.php';

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
$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "Publication.twig"]);
});
$app->get('/Coupe2016/', function ($request, $response, $args) {
    accept_friend_request($this->db,"desmazes","kiki");
    $data = get_user_list($this->db);
    return $this->view->render($response, 'UserTest.twig', ["users" => $data, "basededonner" => $this->db]);
});
$app->get('/Configuration/', function ($request, $response, $args) {
    return $this->view->render($response, 'Configuration.twig', ["name" => "Configuration.twig"]);
});
$app->get('/Publication/', function ($request, $response, $args) {
    return $this->view->render($response, 'Publication.twig', ["name" => "Publication.twig"]);
});
$app->run();