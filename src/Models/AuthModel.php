<?php
namespace App\Models;

use App\Models\MysqlModel,
    App\Lib\Response,
    App\Lib\HashPassword,
    App\Lib\Codigos;

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
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->response->result = null;
            return  $this->response->SetResponse(false,'El correo no es valido use el formato ejemplo@dominio.com.');
        } 
        $validacion = $this->db->from('usuarios')
                               ->where('email',$email)
                               ->fetch();

        if (!$validacion) {
            // generar codigo y data de insercion
            $codigo = Codigos::generar(6);
            $fechaEx = time() + (24 * 60 * 60);
            $data = [
                'codigo'            => $codigo,
                'email'             => $email,
                'status'            => 'activo',
                'fechaExpiracion'   => $fechaEx
            ];
            // insertar en base de datos
            $insertCode = $this->db->insertInto('codigosEmailValidacion')
                                   ->values($data)
                                   ->execute();
            $fecha = date('Y-m-d H:i:s', $fechaEx);
            // envio de mail
            $url = "https://api.sendinblue.com/v3/smtp/email";

            $data = array(
                "sender" => array(
                    "name" => "Azteca Ferries",
                    "email" => "cuentas@aircab.com.mx"
                ),
                "to" => array(
                    array(
                        "email" => "$email",
                        "name" => ""
                    )
                ),
                "subject" => "Codigo de verificaccion Email Azteca Ferries",
                "htmlContent" => "<html><head></head><body><p>Hello,</p>Su codigo de verificaccion es: $codigo.</p></body></html>"
            );

            $payload = json_encode($data);

            $headers = array(
                "accept: application/json",
                "api-key: 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",
                "content-type: application/json"
            );

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);

            curl_close($ch);
            // Enviar el correo electrónico usando la función mail() nativa de PHP
            // if (mail($to, $subject, $message, $headers)) {
                        $this->response->result = null;
                return  $this->response->SetResponse(true,"Se envio un codigo a la cuenta $email con caducidad hasta $fecha.");
            // } else {
            //             $this->response->result = null;
            //     return  $this->response->SetResponse(false,'El correo no se pudo enviar.');
            // }
        }else{
                    $this->response->result = null;
            return  $this->response->SetResponse(false,'La cuenta ya existe.');
        }
    }

    public function validarCode($code,$email){
        
    }

    public function registrarUsuario(){
        
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
 