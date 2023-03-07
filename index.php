<?php
// Headers 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');

// date_default_timezone_set('America/Mexico_City');

require __DIR__ . '/vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use App\Controllers\AuthController;

// Agregar esta línea
$app = AppFactory::create();
$app->setBasePath("/");

require __DIR__ . '/src/loadApp.php';

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

// uso de use AuthMiddleware;
use App\Middleware\AuthMiddleware;

$authMiddleware = new AuthMiddleware();
// rutas

$app->get('/auth', AuthController::class.':index');
$app->get('/getUser', AuthController::class.':index')->add($authMiddleware);

$app->get('/', function (Request $request, Response $response) {
    $response->withHeader('Content-type','application/json')
             ->getBody()->write('Slim 4');
    return $response;
});

$app->run();