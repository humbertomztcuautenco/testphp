<?php
namespace Testphp;

require_once 'vendor/autoload.php';
require 'lib/auth.php';
require 'lib/response.php';
require 'lib/validate.php';
require 'lib/encrypt.php';

use Lib\Auth,
    Lib\Response,
    Lib\Validate,
    Lib\Encrypt;

class Base {
   
    public $auth;
    public $response;
    public $db;
    public $validate;
    public $encrypt;

    public function __CONSTRUCT(){
        $this->db = require 'src/db.php';
        $this->auth = new Auth();
        $this->response = new Response();
        $this->validate = new Validate();
        $this->encrypt = new Encrypt();
    }
}
