# FCM-Puffin-prob_associazioni-Builder


***Per gestire più velocemente i duplicati che vengono dai cicli, mi faccio stampare le query per popolare una' altra tabella, che vado a leggere con una DISTINCT per crearmi l'elenco da copincollare nel prob_associazioni. Questo lo faccio col file selectdistinct.php,  volendo si potrebbe integrare il tutto su un unico file.***

---
Script php per ricostruire da zero il file prob_associazioni.php per l'applicativo PuffinProbForm

Lo script cerca nella pagina https://www.fantacalcio.it/probabili-formazioni-serie-a tutti i giocatori, ne recupera nome fantagazzetta, codice fantagazzetta e squadra di appartenenza. questi dati sono presenti nella URL di ogni giocatore che porta alla propria scheda.
Successivamente carica anche l'elenco di tutti i giocatori presenti nel db di FCM (usando la skin Revo 2.13 il db è su mysql) e tramite una semplice ricerca ricostruisce l'array di prob_associazioni.php stampando a video il testo nella forma: `$arrAssociazioni[n]=array(codice FantaGazzetta,"nome FantaGazzetta",codice FCM,"nome FCM");`

Dopo la configurazione basta lanciarlo e poi copiare il testo ed incollandolo nel file prob_associazioni.php.

## DISCLAIMER

 - Fate un backup del file prob_associazioni!!!!
 - potrebbe mancare o essere sbagliata qualche associazione!!!
 - Non mi assumo nessuna responsabilità in caso di perdita di dati
