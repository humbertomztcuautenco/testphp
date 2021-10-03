<?
namespace Model;
require '../../base.php';
use Testphp\Base;

class AuthModel {
    private $db;
    private $response;
    private $validate;
    private $encrypt;
    private $auth;
    private $table = 'persona';

    public function __CONSTRUCT(){
        $base = new Base();
        $this->db = $base->db;
        $this->response = $base->response;
        $this->validate = $base->validate;
        $this->encrypt = $base->encrypt;
        $this->auth = $base->auth;
    }

    public function login($data){
        $validateDb = $this->validate->validateDb($this->db);
        if(!$validateDb->response) return $validateDb;
        $validateLogin = $this->validate->validateLogin($data);
        if (!$validateLogin->response) return $validateLogin;

        $passArray = array('password' => $this->encrypt->crypt($data['password']));
		$data = array_merge($data, $passArray);

        $persona = $this->db->from($this->table)
                            ->where('idrol',$data['idrol'])
                            ->where('correo',$data['correo'])
                            ->where('password',$data['password'])
                            ->fetch();
        

        if ($persona) {
                $token = $this->auth->encode($persona);

                       $this->response->result = $token;
                return $this->response->SetResponse(true,"Login exitoso");
            }else{
                $this->response->errors = [
                    "auth"=> "Error en las credenciales"
                ];
                return $this->response->SetResponse(false);
            }
    }

}