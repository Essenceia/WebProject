<?php

require 'vendor/autoload.php';
require'data/databaseutility.php';

$app = new \Slim\App;
$app->get('/', function () use ($app) {
    echo "I'm in <br>";
    //require_once 'data/databaseutility.php';
    $db = connect_db();
    if (!$db) {
        die("Connection failed: " . $db->connect_error);
    }else{
        echo "Connection sucessfull <br>";
    $sql = "SELECT email,nom,pseudo FROM webapp.user";
    $result = $db->query($sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row

        while($row = mysqli_fetch_assoc($result)) {
            echo "id: " . get_email($row["email"]). " - Name: " . $row["nom"]. " - Pseudo: ". $row["pseudo"]." <br>";
        friend_list($row["email"],$db);
        }
    } else {
        echo "0 results";
    }

    }
});

$app->run();
/*
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';


$app = new \Slim\App;
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

$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "Intro.twig"]);
});

$app->get('/Fonderie/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "Fonderie.twig"]);
});

$app->get('/LowLevel/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "NATEC.twig"]);
});

$app->get('/Monitor/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "Monitor.twig"]);
});

$app->get('/Drone/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "Drone.twig"]);
});

$app->get('/MeshVisu/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "MeshView.twig"]);
});

$app->get('/OrdBot/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "OrdBot.twig"]);
});

$app->get('/Coupe2016/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.twig', ["name" => "Coupe2016.twig"]);
});

$app->run();*/