<?php
namespace Api\Person;
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
require '../../model/publication_model.php';

use Model\PublicationModel;
$pubs = new PublicationModel();
if ($_SERVER['HTTP_TOKEN']) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $id = $_GET['id'];
            if ($id) {
                echo json_encode($pubs->obtainById($id,$_SERVER['HTTP_TOKEN']));
            }else {
                echo json_encode($pubs->list($_SERVER['HTTP_TOKEN']));
            }
            break;
        case 'POST':
            $body = json_decode(file_get_contents("php://input"),true);
            echo json_encode($pubs->add($body,$_SERVER['HTTP_TOKEN']));
            break;
        case 'PUT':
            $body = json_decode(file_get_contents("php://input"),true);
            echo json_encode($pubs->update($body,$_SERVER['HTTP_TOKEN']));
            break;
        case 'DELETE':
            $id = $_GET['id'];
            echo json_encode($pubs->delete($id,$_SERVER['HTTP_TOKEN']));
            break;
        default:
            echo "Metodo no encontrado";
        break;
    }    
}else{
    echo "you need a token";
}
