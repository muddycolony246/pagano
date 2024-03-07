<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once 'api.php';
$data = json_decode(file_get_contents("php://input"), true);
 
$barcode = $data['barcode'];
$nome = $data['nome'];
$prezzo = $data['prezzo'];
$quantita = $data['quantita'];
$stato = $data['stato'];

if(create($barcode, $nome, $prezzo, $quantita, $stato)){
	http_response_code(201);
	echo json_encode(array("messaggio" => "Utente creato correttamente."));
}
else{
	//503 servizio non disponibile
	http_response_code(503);
	echo json_encode(array("messaggio" => "Impossibile creare l'utente."));
}
$conn->close();
?>