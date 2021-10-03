<?
namespace Model;
require '../../base.php';
use Testphp\Base;
class PersonModel {
    private $db;
    private $response;
    private $validate;
    private $encrypt;
    private $table = 'persona';

    public function __CONSTRUCT(){
        $base = new Base();
        $this->db = $base->db;
        $this->response = $base->response;
        $this->validate = $base->validate;
        $this->encrypt = $base->encrypt;
    }

    public function add($data){
        $validateDb = $this->validate->validateDb($this->db);
        if(!$validateDb->response) return $validateDb;
        $validationData = $this->validate->validatePerson($data);
        if (!$validationData->response) return $validationData;

        $passArray = array('password' => $this->encrypt->crypt($data['password']));
		$data = array_merge($data, $passArray);

        $persona = $this->db->from($this->table)
                            ->where('idrol',$data['idrol'])
                            ->where('correo',$data['correo'])
                            ->fetch();
        if (!$persona) {
           $register = $this->db->insertInto($this->table, $data)
							    ->execute(); #excute(ejecuta la consulta)

                   $this->response->result = ["id"=>$register];
            return $this->response->SetResponse(true,"alta exitosa");
        }else{
            $this->response->errors = [
                "persona"=> "Se encontro a otra persona con los datos de correo y rol iguales"
            ];
            return $this->response->SetResponse(false);
        }
    }

}