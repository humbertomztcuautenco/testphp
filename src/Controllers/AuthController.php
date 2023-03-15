<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\AuthModel;

class AuthController{
    private $auth = null;

    public function __construct(){
        $this->auth = new AuthModel;
    }
    /**
     * @autor: Humberto Mtz Cuautenco
     * @fecha: 9 de marzo de 2023
     * @comenatrio: validar email
     */
    function validarEmail(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $res->withHeader('Content-type','application/json')
            ->getBody()->write(json_encode( $this->auth->validarEmail($parametros)));
        return $res;
    }
    /**
     * @autor: Humberto Mtz Cuautenco
     * @fecha: 14 de marzo de 2023
     * @comenatrio: validar codigo
     */
    function validarCodigo(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $res->withHeader('Content-type','application/json')
            ->getBody()->write(json_encode( $this->auth->validarCodigo($parametros)));
        return $res;
    }
    /**
     * @autor: Humberto Mtz Cuautenco
     * @fecha: 14 de marzo de 2023
     * @comenatrio: registro de usuario 
     */
    function registrarUsuario(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $res->withHeader('Content-type','application/json')
            ->getBody()->write(json_encode( $this->auth->registrarUsuario($parametros)));
        return $res;
    }

    function auth(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->auth->auth($parametros)));
        return $res;
    }

    public function getUser(Request $req, Response $res, $args){
        
    }
}