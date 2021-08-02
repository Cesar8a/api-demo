<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require "vendor/autoload.php";
require "lib/dbConnection.Class.php";

$app = new \Slim\App;

/*
$config = ["settings" => [
	"displayErrorDetails" => true
]];

$app = new Slim\App($config);
*/

$app->get("/", function (Request $request, Response $response){
	$response->getBody()->write("El API esta en ejecucion");

	return $response;
});

//Rutas de usuarios
require "users.php";


//Add route callbacks
/*
$app->get('/root', function ($request, $response, $args) {
    return $response->withStatus(400)->write('Hello World!');
});

$app->get("/hello/{name}", function (Request $request, Response $response, array $args){
	$name = $args["name"];
	$response->getBody()->write("Hello, $name");

	return $response;
});
*/

/*
$app->get('/foo', function (ServerRequestInterface $request, ResponseInterface $response) {
    // Use the PSR-7 $request object
    return $response;
});
*/

$app->run();

?>