<?php

//io uso la vecchissima versione di revo, il cui database è caricato online su Mysql, si puo cambiare la connessione per interfacciarlo con l'mdb di FCM
// Variabili per la connessione al database (da configurare)
$host = "Database_Host";
$username = "username";
$password = "password"; // Sostituisci con la tua password
$db_name = "database";

// Creazione della connessione al database
try {
    $conn = new mysqli($host, $username, $password, $db_name);
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    } else {
        //echo "Connessione al database riuscita!";
    }
} catch (Exception $e) {
    echo "Errore durante la connessione: " . $e->getMessage();
}

// Carica il contenuto della pagina, la pagina probabili formazioni è più completa
//$url = 'https://www.fantacalcio.it/voti-fantacalcio-serie-a';
$url = 'https://www.fantacalcio.it/probabili-formazioni-serie-a';
$html = file_get_contents($url);

// Crea un nuovo documento DOM
$doc = new DOMDocument();
libxml_use_internal_errors(true); // Sopprime gli avvisi
$doc->loadHTML($html);

// Seleziona tutti gli elementi con la classe specificata, nei link che sul sito portano alla scheda giocatore si trova sia il nome che il codice Fantacalcio.it
$xpath = new DOMXPath($doc);
$elements = $xpath->query('//a[@class="player-name player-link"]');

// Inizializza un array per i risultati
$giocatori = [];

// Itera sugli elementi trovati
foreach ($elements as $element) {
    $href = $element->getAttribute('href');
    // Estrai gli ultimi 3 elementi del link squadra, nome e codice (puoi personalizzare questa parte)
    $parti = explode('/', $href);
    $squadra = $parti[count($parti) - 3];
    $nomeCompleto = $parti[count($parti) - 2];
    // Rimuovi i trattini e le lettere successive SOLO se seguono una parola di più di 3 caratteri
    $nomeParti = explode('-', $nomeCompleto);
    $nome = '';
    foreach ($nomeParti as $parte) {
        if (strlen($parte) > 3 || $nome === '') {
            $nome .= $parte . '-';
        }
    }
    // Sostituisci TUTTI i trattini nel nome finale con spazi
    $nome = str_replace('-', ' ', $nome);

    $codice = $parti[count($parti) - 1];

    // Aggiungi i dati all'array dei giocatori
    $giocatori[] = [
        'squadra' => $squadra,
        'nome' => $nome,
        'codice' => $codice
    ];
    //var_dump($giocatori);
}
// Eseguiamo la query per ottenere i dati dal database
$sql = "SELECT Giocatore, Squadra, Cod FROM `fantamaniaci_revo`.`revo_stats`;";
$result = $conn->query($sql);

// Creazione di un array associativo per memorizzare i giocatori del database
$giocatoriDB = [];
while ($row = $result->fetch_assoc()) {
    $giocatoriDB[$row['Giocatore']] = $row;
}

// Confronto tra i giocatori dell'array e quelli del database (con ricerca parziale)
$conta=0;
foreach ($giocatori as $cod => $giocatore) {
    
    $nomeCompleto = trim($giocatore['nome']); // Rimuovi spazi iniziali e finali
    $trovato = false;

    // Iniziamo dalla stringa completa e accorciamo progressivamente
    for ($i = strlen($nomeCompleto); $i > 0; $i--) {
        $nomeParziale = substr($nomeCompleto, 0, $i);
        $searchPattern = "{$nomeParziale}";

        foreach ($giocatoriDB as $nomeDB => $datiGiocatore) {

            if (stripos(trim($nomeDB), $searchPattern) !== false) { // Rimuovi spazi anche nel nome del DB
                
                echo ("\$arrAssociazioni[{$conta}]=array({$giocatore['codice']},\"".ucfirst(trim($giocatore['nome']))."\",{$datiGiocatore['Cod']},\"{$datiGiocatore['Giocatore']}\",\"{$datiGiocatore['Squadra']}\"");
                echo");<br>";
                $conta ++;
                $trovato = true;
                break 2; // Esci da entrambi i cicli se troviamo una corrispondenza
            }
        }

        if ($trovato) {
            break; // Esci dal ciclo esterno se abbiamo trovato una corrispondenza
        }
    }

    if (!$trovato) {
        echo "Giocatore {$giocatore['nome']} non trovato nel database (motivo: {$nomeCompleto})<br>";
    }
}
// Chiusura della connessione al database
$conn->close();
