<?php
namespace Lib;
use Firebase\JWT\JWT,  
    Lib\Response;

class Auth {

   private $time;
   private $key = 'TES@902)(@#@';
   private $response;
    // private $token = array();

    public function __CONSTRUCT(){
        $this->response = new Response();
		$this->time = time();
        $this->token = array(
            'iat' => $this->time,
            'exp' => $this->time + (60*60),
            'data' => [],
            //campo aud
        );
        $this->response = new Response();
	}

    public function encode($data){
        $this->token['data'] = $data;
        return JWT::encode($this->token,$this->key);
    }

    public function decode($jwt){
        return JWT::decode($jwt, $this->key, array('HS256'));
    }

    public function checkToken($token,$accion){
        try {
            $decode = JWT::decode($token,$this->key, array('HS256'));
            $permiso = false;
            $rol = $decode->data->idrol;
            // return $decode->data;
            switch ($accion) {
                case 'GET':
                    if ($rol == 2 || $rol == 4 || $rol == 5) $permiso = true;
                    break;
                case 'POST':
                    if ($rol >= 3 && $rol <= 5) $permiso = true;
                    
                    break;
                case 'PUT':
                    if ($rol >= 4 && $rol <= 5) $permiso = true;
                    
                    break;
                case 'DELETE':
                    if ($rol == 5) $permiso = true;
                    break;
            }
                   $this->response->errors = ["persona"=>"No tienes los permisos necesarios para poder acceder a esta funcionalidad."];
            return $this->response->setResponse($permiso);
             
        } catch(\Exception $e) {
            $this->response->errors = ["token" => $e->getMessage()];
            return $this->response->setResponse(false);
        }
    }
}
