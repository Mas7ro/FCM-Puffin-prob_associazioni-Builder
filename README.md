# FCM-Puffin-prob_associazioni-Builder

**Generatore automatico dell'array di associazioni tra giocatori FantaGazzetta e FCM**

Questo script PHP ricostruisce il file `prob_associazioni.php` necessario per il plugin **PuffinProbForm**, automatizzando l'associazione tra i giocatori di Serie A da FantaGazzetta e quelli presenti nel database FCM.

---

## 🎯 Funzionalità

- **Web Scraping**: Estrae automaticamente i giocatori da [fantacalcio.it/probabili-formazioni-serie-a](https://www.fantacalcio.it/probabili-formazioni-serie-a)
- **Parsing Intelligente**: Ricostruisce i nomi dei giocatori dal formato URL (gestione di trattini e nomi composti)
- **Matching Fuzzy**: Associa i giocatori FantaGazzetta a quelli FCM con ricerca parziale
- **Output Pronto**: Genera PHP code direttamente utilizzabile come array di associazioni
- **Validazione**: Segnala i giocatori non trovati nel database FCM

---

## 📋 Requisiti Tecnici

- **PHP**: 5.5+
- **Estensioni PHP richieste**:
  - `MySQLi` (connessione database)
  - `cURL` (web scraping)
  - `libxml` e `DOM` (parsing HTML)
- **Database**: MySQL con accesso remoto/locale
- **Connettività**: Accesso HTTP a fantacalcio.it

---

## ⚙️ Configurazione

Modifica le seguenti variabili nel file `puffin_prob_associazioni_buider.php`:

```php
$host = "Database_Host";        // Indirizzo server MySQL
$username = "username";          // Utente database
$password = "password";          // Password database
$db_name = "database";           // Nome database
```

### Query Database
Lo script esegue questa query:
```sql
SELECT Giocatore, Squadra, Cod FROM `fantamaniaci_revo`.`revo_stats`;
```
Adatta il nome del database/tabella se diverso (es. per altre versioni di Revo o database FCM).

---

## 🚀 Utilizzo

1. **Configurare le credenziali** del database nel file PHP
2. **Eseguire lo script**:
   ```bash
   php puffin_prob_associazioni_buider.php
   ```
3. **Output**: Lo script stampa a schermo l'array PHP da inserire in `prob_associazioni.php`:
   ```php
   $arrAssociazioni[0]=array(codice_FG,"Nome FG",codice_FCM,"Nome FCM","Squadra");
   $arrAssociazioni[1]=array(...);
   ```

---

## 🔍 Algoritmo di Matching

Lo script utilizza un algoritmo di ricerca progressiva:

1. **Estrazione da FantaGazzetta**: Recupera nome, squadra e codice dall'URL del giocatore
2. **Parsing nomi**: 
   - Divide il nome su trattini
   - Mantiene solo le parti con più di 3 caratteri (escludendo diminutivi)
   - Converte trattini in spazi
3. **Ricerca nel database FCM**:
   - Estrae il cognome dal database con regex (`/^\w+/`)
   - Ricerca parziale case-insensitive (`stripos()`)
   - Verifica corrispondenza della squadra
   - Usa substring progressivo (da lunghezza completa in giù)
4. **Deduplicazione**: Evita associazioni duplicate con chiave unica `codice_FG_codice_FCM`
5. **Reporting**: Segnala i giocatori non trovati

---

## ⚠️ Limitazioni Conosciute

- **Nomi composti**: Possibili errori con cognomi doppi (es. "De Sanctis", "La Rosa")
- **Apici e caratteri speciali**: Possono causare errori di parsing
- **Cambi di formazione**: Se la pagina di FantaGazzetta cambia struttura HTML, lo script potrebbe fallire
- **Precisione**: Non garantisce il 100% di accuratezza; verificare manualmente i risultati

### Nota dell'autore (2025)
> Ci sono ancora problemi con alcuni giocatori (circa 6 non vengono riconosciuti). Sono stati corretti manualmente a mano. Miglioramenti futuri al codice sono benvenuti.

---

## 📌 Disclaimer Importante

⚠️ **FARE UN BACKUP DI `prob_associazioni.php` PRIMA DI ESEGUIRE LO SCRIPT**

- Questo script è fornito "così com'è" senza garanzie
- L'autore non si assume responsabilità per perdita di dati
- Testare in ambiente di sviluppo prima della produzione
- Alcune associazioni potrebbero essere mancanti o errate
- Verificare sempre l'output prima di utilizzo in produzione

---

## 📝 Esempio Output

```
$arrAssociazioni[0]=array(12345,"Vlahovic",54321,"Vlahovic","juve");
$arrAssociazioni[1]=array(12346,"Dybala",54322,"Dybala","roma");
...
Giocatore Rossi (Squadra: inter) non trovato nel database (motivo: rossi)
```

---

## 🔗 Correlazioni

- **FantaGazzetta**: [Probabili Formazioni Serie A](https://www.fantacalcio.it/probabili-formazioni-serie-a)
- **Plugin correlato**: PuffinProbForm
- **Database**: Revo 2.13 (o compatibili)

---

**Ultima modifica**: Aprile 2026
