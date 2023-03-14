<?php
namespace App\Models;

use PDO;

class MysqlModel {
    public $sqlPDO = null;
    public function __CONSTRUCT(){
        try {
            $host = $_ENV['HOST'];
            $db = $_ENV['DATABASE'];
            $dns = "mysql:host=$host;dbname=$db;charset=utf8";
            $user = $_ENV['USERNAME'];
            $pass = $_ENV['PASSWORD'];
            
            $pdo = new PDO($dns,$user, $pass);

            $this->sqlPDO = new \Envms\FluentPDO\Query($pdo);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}