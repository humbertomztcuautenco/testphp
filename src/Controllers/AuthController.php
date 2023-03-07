<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\AuthModel;

class AuthController{
    function index (Request $request, Response $response, $args){
        $auth = new AuthModel;
        $response   ->withHeader('Content-type','application/json')
                    ->getBody()->write(json_encode( $auth->sendValidateCode('52','7761052213',1)));
        return $response;
    }
}