<?php
use App\Controllers\AuthController;
use App\Middleware\AuthMiddleware;
use Slim\Routing\RouteCollectorProxy;

$authMiddleware = new AuthMiddleware();

$app->group('/api/', function (RouteCollectorProxy $group) use ($authMiddleware) {
    // * validar email
    $group->post('validarEmail', AuthController::class.':validarEmail');
    $group->post('validarCodigo', AuthController::class.':validarCodigo');
    $group->post('registrarUsuario', AuthController::class.':registrarUsuario')->add($authMiddleware);
    //* auth 
    $group->post('auth', AuthController::class.':auth');
    $group->get('getUser', AuthController::class.':getUser')->add($authMiddleware);
});