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

// Carica il contenuto della pagina
//$url = 'https://www.fantacalcio.it/voti-fantacalcio-serie-a';
$url = 'https://www.fantacalcio.it/probabili-formazioni-serie-a';
$html = file_get_contents($url);

// Crea un nuovo documento DOM
$doc = new DOMDocument();
libxml_use_internal_errors(true); // Supprime gli avvisi
$doc->loadHTML($html);

// Seleziona tutti gli elementi con la classe specificata
$xpath = new DOMXPath($doc);
$elements = $xpath->query('//a[@class="player-name player-link"]');

// Inizializza un array per i risultati
$giocatori = [];

// Itera sugli elementi trovati
foreach ($elements as $element) {
    $href = $element->getAttribute('href');
    // Estrai gli ultimi 3 elementi del link (puoi personalizzare questa parte)
    $parti = explode('/', $href);
    $squadra = $parti[count($parti) - 3];
    $nomeCompleto = $parti[count($parti) - 2];
    //echo($nomeCompleto."<br>");
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
// echo "// Array per associare il nome e i codici del giocatore su FantaGazzetta con il nome e i codici in FCM
// // \$arrAssociazioni[0]=array(codice FantaGazzetta,\"nome FantaGazzetta\",codice FCM,\"nome FCM\");<br>";

$conta=0;

foreach ($giocatori as $cod => $giocatore) {
    $nomeCompleto = trim($giocatore['nome']);
    //$nomeCompletoMaiuscolo = strtoupper($nomeCompleto); // Converti tutto in maiuscolo per semplificare la ricerca

    $trovato = false;

    // Iniziamo dalla stringa completa e accorciamo progressivamente
    for ($i = strlen($nomeCompleto); $i > 0; $i--) {
        $nomeParzialeMaiuscolo = substr($nomeCompleto, 0, $i);

        foreach ($giocatoriDB as $nomeDB => $datiGiocatore) {
            // Estrai solo la parte maiuscola del nome dal database
            preg_match('/^\w+/', $nomeDB, $cognomeDB);// Rimuove tutte le parole in minuscolo
            $cognomeDB = implode($cognomeDB);;
            //echo("<br>");
            if (stripos($cognomeDB, $nomeParzialeMaiuscolo) !== false) {
                // Trovata corrispondenza sul cognome
                //echo ("\$arrAssociazioni[{$conta}]=array({$giocatore['codice']},\"".ucfirst(trim($giocatore['nome']))."\",{$datiGiocatore['Cod']},\"{$datiGiocatore['Giocatore']}\",\"{$datiGiocatore['Squadra']}\"");
                //adasd');
                echo ("INSERT INTO `test`.`test` (`testo`) VALUES ('array({$giocatore['codice']},\"".ucfirst(trim($giocatore['nome']))."\",{$datiGiocatore['Cod']},\"{$datiGiocatore['Giocatore']}\",\"{$datiGiocatore['Squadra']}\"");
                echo");');<br>";
                //Per gestire più velocemente i duplicati che fuoriescono dai cicli, mi faccio stampare le query per popolare una' altra tabella, che vado a leggere con una DISTINCT
                //che lancio col file selectdistinct.php, volendo si potrebbe integrare il tutto su un unico file
                $conta ++;
                $trovato = true;
                break 2;
            }
        }

        if ($trovato) {
            break;
        }
    }

    if (!$trovato) {
        echo "Giocatore {$giocatore['nome']} non trovato nel database (motivo: {$nomeCompleto})<br>";
    }
}
//echo "</table>";

// Chiusura della connessione al database
$conn->close();
