<?php
namespace App\Models;

use App\Models\MysqlModel,
    App\Lib\Response;

class AuthModel {
    private $db = null;
    private $response;

    public function __construct(){
        $db = new MysqlModel();
        $this->db = $db->sqlPDO;
        $this->response = new Response();
    }

    public function sendValidateCode($codigoPais, $telefono, $tipoUsuarioId){
                $this->response->result = null;
        return  $this->response->SetResponse(true,'Agregado con exito');
    }

}
 