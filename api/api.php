<?php
$server = "127.0.0.1";
$username = "root";
$password = "";
$db = "my_matteorampolla";

// Creiamo la connessione
$conn = new mysqli($server, $username, $password, $db);

// Verifichiamo che non ci siano stati errori nella connessione
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

function readAll(){
    global $conn;
    // Seleziono tutti gli utenti
    $query = "SELECT barcode, nome, prezzo, quantita, stato FROM utenti";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return array(); // Restituisce un array vuoto se non ci sono utenti
    }
}

function readUser($barcode){
    global $conn;
    // Seleziono l'utente con il barcode specificato
    $query = "SELECT barcode, nome, prezzo, quantita, stato FROM utenti WHERE barcode=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $barcode);
    $stmt->execute();
    $result = $stmt->get_result();
    $utente = $result->fetch_assoc();
    $stmt->close();
    return $utente;
}


function create($barcode, $nome, $prezzo, $quantita, $stato){
	global $conn;
	$query = "INSERT INTO utenti (barcode, nome, prezzo, quantita, stato) values ('$barcode', '$nome','$prezzo','$quantita','$stato')";
	if ($conn->query($query) === TRUE) {
	  return true;
	}
	return false;
}


function update($barcode, $nome, $prezzo, $quantita, $stato){
    global $conn;
    // Aggiorno l'utente con il barcode specificato
    $query = "UPDATE utenti SET nome=?, prezzo=?, quantita=?, stato=? WHERE barcode=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdds", $nome, $prezzo, $quantita, $barcode, $stato);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $stmt->close();
}

function delete($barcode){
    global $conn;
    // Elimino l'utente con il barcode specificato
    $query = "DELETE FROM utenti WHERE barcode=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $barcode);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $stmt->close();
}

?>
