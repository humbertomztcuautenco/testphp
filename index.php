<?php
// Headers 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');

require __DIR__ . '/vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

//env 
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

//* crear app y activar reescritura

$app = AppFactory::create();

if (PHP_SAPI == 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}
// cargar todos los elementos de la app
require __DIR__ . '/src/loadApp.php';

$app->get('/', function (Request $request, Response $response) {
    // $dbHost = $_ENV['HOST'];
    $response->withHeader('Content-type','application/json')
             ->getBody()->write("Slim 4 ");
    return $response;
});

$app->get('/list', function (Request $request, Response $response) {
    // Lee el contenido del archivo HTML
    $content = file_get_contents('archivo.html');

    // Devuelve el contenido como respuesta
    $response->getBody()->write($content);

    return $response;
});

$app->post('/', function (Request $req, Response $res, $args) {
    $parametros = json_decode($req->getBody()->getContents());
    $text = $parametros->text;
    $date = $parametros->date;
    // Abre el archivo en modo escritura
    $archivo = fopen('archivo.html', 'a');

    // Escribe el texto en el archivo
    fwrite($archivo, "$text - $date \n");

    // Cierra el archivo
    fclose($archivo);
    $res->withHeader('Content-type','application/json')
             ->getBody()->write("Slim 4 ");
    return $res;
});

$app->run();