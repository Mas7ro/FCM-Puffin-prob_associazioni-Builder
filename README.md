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

