<?php
namespace App\Models;

use App\Models\MysqlModel,
    App\Lib\Response,
    App\Lib\HashPassword,
    App\Lib\Codigos,
    App\Lib\Auth;

class AuthModel {
    private $db = null;
    private $response;

    public function __construct(){
        $db = new MysqlModel();
        $this->db = $db->sqlPDO;
        $this->response = new Response();
    }

    public function validarEmail($parametros){
        $email = $parametros->email;
        $tipoUser = $parametros->tipoUser;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->response->result = null;
            return  $this->response->SetResponse(false,'El correo no es valido use el formato ejemplo@dominio.com.');
        } 
        $validacion = $this->db->from('usuarios')
                               ->where('email',$email)
                               ->where('tipo_usuario',$tipoUser)
                               ->fetch();

        if (!$validacion) {
            // generar codigo y data de insercion
            $codigo = Codigos::generar(6);
            $fechaEx = time() + (24 * 60 * 60);
            $data = [
                'codigo'            => $codigo,
                'email'             => $email,
                'status'            => 'activo',
                'fechaExpiracion'   => $fechaEx,
                'tipo_usuario'      => $tipoUser
            ];
            // insertar en base de datos
            $insertCode = $this->db->insertInto('codigosEmailValidacion')
                                   ->values($data)
                                   ->execute();
            
            // Enviar el correo electrónico usando la función mail() nativa de PHP
            
            // if (mail($to, $subject, $message, $headers)) {
                        $this->response->result = null;
                return  $this->response->SetResponse(true,"Se envio un codigo a la cuenta $email con caducidad de 24 horas.");
            // } else {
            //             $this->response->result = null;
            //     return  $this->response->SetResponse(false,'El correo no se pudo enviar.');
            // }
        }else{
                    $this->response->result = null;
            return  $this->response->SetResponse(false,'La cuenta ya existe.');
        }
    }

    public function validarCodigo($parametros){
        // $code,$email,$tipoUser
        $code = $parametros->codigo;
        $email = $parametros->email;
        $tipoUser = $parametros->tipoUser;
        $fecha = time();
        // echo $fecha;
        $getCode = $this->db->from('codigosEmailValidacion')
                         ->where('codigo',$code)
                         ->where('status','activo')
                         ->where('fechaExpiracion >= ?',$fecha)
                         ->where('email',$email)
                         ->where('tipo_usuario',$tipoUser)
                         ->orderBy('idcodigosEmailValidacion DESC')
                         ->fetch();

        if ($getCode) {
            // update campo de codigo
            $this->db->update('codigosEmailValidacion')
                        ->set(array('status' => 'inactivo'))
                        ->where('idcodigosEmailValidacion = ?', $getCode['idcodigosEmailValidacion'])
                        ->execute();
            // generar token de validacion
            $tokenReg = Auth::LogReg($getCode);
                    $this->response->result = $tokenReg;
            return  $this->response->SetResponse(false,'Codigo encontrado.');
        } else {
                    $this->response->result = null;
            return  $this->response->SetResponse(false,'Codigo no valido.');
        }
    }

    public function registrarUsuario($parametros){
        // alta en la base de datos
        var_dump($parametros);
        // $parametros = get_object_vars($parametros);
        // $registro = $this->db->insertInto('usuarios',$parametros)
        //                      ->execute();
        // var_dump($registro);
        // alta de carpeta de imagen del user
        // var_dump($_SERVER['DOCUMENT_ROOT']);
        // $carpeta = 'img/user/';
        // $ruta = $_SERVER['DOCUMENT_ROOT'] . '/' . $carpeta;

        // if (!file_exists($ruta)) {
        //     mkdir($ruta, 0777, true); // crea la carpeta con permisos de lectura y escritura
        // }

        // chmod($ruta, 0777); // asigna permisos de lectura y escritura a la carpeta

    }

    public function auth($parametro){
        $user = $parametro->user;
        $password = HashPassword::hash($parametro->password);

        $authUser = $this->db->from('usuarios')
                         ->where('email',$user)
                         ->where('password',$password)
                         ->fetch();

                $this->response->result = $authUser;
        return  $this->response->SetResponse(true,'Success');
    }

}
 