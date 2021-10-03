<?
namespace Model;
require '../../base.php';
use Testphp\Base;
class PublicationModel {
    private $db;
    private $response;
    private $validate;
    private $encrypt;
    private $auth;
    private $table = 'publicacion';

    public function __CONSTRUCT(){
        $base = new Base();
        $this->db = $base->db;
        $this->response = $base->response;
        $this->validate = $base->validate;
        $this->encrypt = $base->encrypt;
        $this->auth = $base->auth;
    }
    public function add($data,$token){
        $validateDb = $this->validate->validateDb($this->db);
        if(!$validateDb->response) return $validateDb;
        $res = $this->auth->checkToken($token,'POST');
        if (!$res->response) return $res;
        $validatePublication = $this->validate->validatePublication($data);
        if(!$validatePublication->response) return $validatePublication;
        
        $register = $this->db->insertInto($this->table, $data)
							 ->execute(); #excute(ejecuta la consulta)

        if ($register) {
                   $this->response->result = ["id"=>$register];
            return $this->response->SetResponse(true,"alta exitosa");
        } else {
                   $this->response->errors = ["publicacion"=>"no se encontro el elemento."];
            return $this->response->setResponse(false);
        }
    }
    public function obtainById($id,$token){
        $validateDb = $this->validate->validateDb($this->db);
        if(!$validateDb->response) return $validateDb;
        $res = $this->auth->checkToken($token,'GET');
        if (!$res->response) return $res;

        $data = $this->db->from($this->table)
                         ->where('idpublicacion',$id)
                         ->fetch();

        if ($data) {
                   $this->response->result = $data;
            return $this->response->setResponse(true);
        } else {
                   $this->response->errors = ["publicacion"=>"no se encontro el elemento."];
            return $this->response->setResponse(false);
        }
        

    }
    public function list($token){
        $validateDb = $this->validate->validateDb($this->db);
        if(!$validateDb->response) return $validateDb;
        $res = $this->auth->checkToken($token,'GET');
        if (!$res->response) return $res;

        $data = $this->db->from($this->table)
                         ->fetchAll();

        if (count($data)>0) {
                   $this->response->result = $data;
            return $this->response->setResponse(true);
        } else {
                   $this->response->errors = ["publicacion"=>"no hay elementos."];
            return $this->response->setResponse(false);
        }

    }
    public function update($data,$token){
        $validateDb = $this->validate->validateDb($this->db);
        if(!$validateDb->response) return $validateDb;
        $res = $this->auth->checkToken($token,'PUT');
        if (!$res->response) return $res;
        $validatePublication = $this->validate->validatePublication($data,true);
        if(!$validatePublication->response) return $validatePublication;
        
        $getByIb = $this->obtainById($data['idpublicacion'],$token);
        if (!$getByIb->response) return $getByIb;

        $update = $this->db->update($this->table,$data)
                           ->where('idpublicacion',$data['idpublicacion'])
                           ->execute();
        if($update){
                   $this->response->result = $data;
            return $this->response->setResponse(true);
        }else{
                   $this->response->errors = ["publicacion"=>"no se pudo actulizar la publicaion."];
            return $this->response->setResponse(false);
        }
        
    }
    public function delete($id,$token){
        $validateDb = $this->validate->validateDb($this->db);
        if(!$validateDb->response) return $validateDb;
        $res = $this->auth->checkToken($token,'DELETE');
        if (!$res->response) return $res;

        $getByIb = $this->obtainById($id,$token);
        if (!$getByIb->response) return $getByIb;

        $delete = $this->db->delete($this->table)
                           ->where('idpublicacion',$id)
                           ->execute();
        
        if($delete){
                   $this->response->result = $getByIb->result;
            return $this->response->setResponse(true);
        }else{
                   $this->response->errors = ["publicacion"=>"no se pudo actulizar la publicaion."];
            return $this->response->setResponse(false);
        }
    }

}