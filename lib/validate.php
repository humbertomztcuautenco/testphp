<?php
namespace Lib;
use Lib\Response;

class Validate {
    public static function validateDB($db){
        $response = new Response();
        if(!is_object($db)){
            $response->errors["db"][] = $db;
        }
        $response->setResponse(count($response->errors) === 0);
        return $response;
    }

    public static function validateLogin($data){
        $response = new Response();
        $key = 'correo';
        if(empty($data[$key])) {
            $response->errors[$key][] = 'Este campo es obligatorio';
        } else {
            $value = $data[$key];
            if(!filter_var($value,FILTER_VALIDATE_EMAIL)) {
                $response->errors[$key][] = 'Valor ingresado no es un correo';
            }
        }

        $key = 'password';
        if(empty($data[$key])) {
            $response->errors[$key][] = 'Este campo es obligatorio';
        }else {
            $value = $data[$key];

              if(strlen($value) < 8) {
                  $response->errors[$key][] = 'Debe contener como mínimo 8 caracteres';
              }
        }

        $key = 'idrol';
        if(empty($data[$key])) {
            $response->errors[$key][] = 'Este campo es obligatorio';
        } else {
            $value = $data[$key];
            if($value <= 0 || $value >= 6 ) {
                $response->errors[$key][] = 'Valor ingresado no valido';
            }
        }

        $response->setResponse(count($response->errors) === 0);

        return $response;

    }

    public static function validatePublication($data,$update = false){
        $response = new Response();
        
        $key = 'idpublicacion';
        if ($update) {
            if(empty($data[$key])) {
                $response->errors[$key][] = 'Este campo es obligatorio';
            }else {
                $value = $data[$key];
    
                if($value <= 0) {
                    $response->errors[$key][] = 'Debe de ser un entero mayor de 0';
                }
            }
        }

        $key = 'titulo';
        if (!$update) {
            if(empty($data[$key])) {
                $response->errors[$key][] = 'Este campo es obligatorio';
            }else {
                $value = $data[$key];
    
                if(strlen($value) < 4) {
                    $response->errors[$key][] = 'Debe contener como mínimo 4 caracteres';
                }else if (strlen($value) > 100) {
                    $response->errors[$key][] = 'Debe contener como maximo 100 caracteres';
                }
            }
        }
        

        $key = 'descripcion';
        if (!$update) {
            if(empty($data[$key])) {
                $response->errors[$key][] = 'Este campo es obligatorio';
            }else {
                $value = $data[$key];
    
                if(strlen($value) < 4) {
                    $response->errors[$key][] = 'Debe contener como mínimo 4 caracteres';
                }else if (strlen($value) > 450) {
                    $response->errors[$key][] = 'Debe contener como maximo 450 caracteres';
                }
            }
        }

        $response->setResponse(count($response->errors) === 0);

        return $response;
    }

    public static function validatePerson($data,$update = false){
        $response = new Response();
        $key = 'nombre';
        if(empty($data[$key])) {
            $response->errors[$key][] = 'Este campo es obligatorio';
        }

        $key = 'apellidos';
        if(empty($data[$key])) {
            $response->errors[$key][] = 'Este campo es obligatorio';
        } else {
            $value = $data[$key];

            if(strlen($value) < 4) {
                $response->errors[$key][] = 'Debe contener como mínimo 4 caracteres';
            }
        }

        $key = 'correo';
        if(empty($data[$key])) {
            $response->errors[$key][] = 'Este campo es obligatorio';
        } else {
            $value = $data[$key];
            if(!filter_var($value,FILTER_VALIDATE_EMAIL)) {
                $response->errors[$key][] = 'Valor ingresado no es un correo';
            }
        }

        $key = 'password';
        if (!$update) {
          if(empty($data[$key])){
              $response->errors[$key][] = 'Este campo es obligatorio';
          } else {
              $value = $data[$key];

              if(strlen($value) < 8) {
                  $response->errors[$key][] = 'Debe contener como mínimo 8 caracteres';
              }
          }
        }else {
          if(!empty($data[$key])){
              $value = $data[$key];
              if(strlen($value) < 8) {
                  $response->errors[$key][] = 'Debe contener como mínimo 8 caracteres';
              }
          }
        }

        $key = 'idrol';
        if(empty($data[$key])) {
            $response->errors[$key][] = 'Este campo es obligatorio';
        } else {
            $value = $data[$key];
            if($value <= 0 || $value >= 6 ) {
                $response->errors[$key][] = 'Valor ingresado no valido';
            }
        }

        $response->setResponse(count($response->errors) === 0);

        return $response;

    }
}