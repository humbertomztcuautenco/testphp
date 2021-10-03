<?php
namespace Api\Person;
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
require '../../model/auth_model.php';

use Model\AuthModel;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $body = json_decode(file_get_contents("php://input"),true);
        $auth = new AuthModel();
        echo json_encode($auth->login($body));
        break;
    default:
        echo "Metodo no encontrado";
    break;
                    
}
