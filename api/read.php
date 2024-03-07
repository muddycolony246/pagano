<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once 'api.php';
$risposta;
if(isset($_GET['barcode'])){
	$risposta=readUser($_GET['barcode']);
}
else{
	$risposta=readAll();
}
http_response_code(200);
echo json_encode($risposta);

$conn->close();
?>