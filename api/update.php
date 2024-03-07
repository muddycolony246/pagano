<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

include_once 'api.php';
$data = json_decode(file_get_contents("php://input"), true);
 
$barcode = $data['barcode'];
$nome = $data['nome'];
$prezzo = $data['prezzo'];
$quantita = $data['quantita'];
$stato = $data['stato'];
 
if(update($barcode, $nome, $prezzo, $quantita, $stato)){
    http_response_code(200);
    echo json_encode(array("messaggio" => "Utente aggiornato"));
}else{
    //503 service unavailable
    http_response_code(503);
    echo json_encode(array("messaggio" => "Impossibile aggiornare l'Utente"));
}
$conn->close();
?>