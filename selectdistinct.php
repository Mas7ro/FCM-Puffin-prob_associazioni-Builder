<?php
$host = "Database_Host";
$username = "username";
$password = "password"; // Sostituisci con la tua password
$db_name = "test";

// Crea la connessione
$conn = new mysqli($host, $username, $password, $db_name);

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Esegui la query
$sql = "SELECT DISTINCT test.testo FROM test.test";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $n = 0;
    // Output dei dati di ogni riga
    while ($row = $result->fetch_assoc()) {
        $riga = $row['testo'];
        echo "\$arrAssociazioni[" . $n . "] = " . $riga . "<br>";
        $n++;
    }
} else {
    echo "Nessun risultato trovato.";
}

// Chiudi la connessione
$conn->close();
?>
