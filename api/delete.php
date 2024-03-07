<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");

include_once 'api.php';
$data = json_decode(file_get_contents("php://input"), true);
 
$barcode = $data['barcode'];
 
if(delete($barcode)){
    http_response_code(200);
    echo json_encode(array("messaggio" => "L'utente e' stato eliminato"));
}else{
    //503 service unavailable
    http_response_code(503);
    echo json_encode(array("messaggio" => "Impossibile eliminare l'Utente."));
}
$conn->close();
?>