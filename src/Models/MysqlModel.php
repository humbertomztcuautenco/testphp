<?php
namespace App\Models;
use App\Config\Config;

use PDO;

class MysqlModel {
    public $sqlPDO = null;
    public function __CONSTRUCT(){
        try {
            $stringDB = Config::getStringsDB();
            $host = $stringDB['host'];
            $db = $stringDB['db'];
            $dns = "mysql:host=$host;dbname=$db;charset=utf8";
            $user = $stringDB['user'];
            $pass = $stringDB['pass'];
            
            $pdo = new PDO($dns,$user, $pass);

            $this->sqlPDO = new \Envms\FluentPDO\Query($pdo);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}