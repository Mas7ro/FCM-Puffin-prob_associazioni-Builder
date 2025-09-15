# FCM-Puffin-prob_associazioni-Builder


**puffin_prob_associazioni_buider.php** ricostruisce il contenuto del file **prob_associazioni.php** che serve a scaricare le propabiltà di titolarità dei calciatori di serie A nel plugin di FantaCalcioManager **PuffinProbForm**
**CREDO CI SIA ANCORA QUALCHE PROBLEMA, NON SONO SICURO DELLA PRECISIONE DEGLI SCRIPT**

---
Script php per aggiornare il file **prob_associazioni.php** per l'applicativo **PuffinProbForm**

Lo script cerca nella pagina https://www.fantacalcio.it/probabili-formazioni-serie-a tutti i giocatori, ne recupera nome fantagazzetta, codice fantagazzetta e squadra di appartenenza. Questi dati sono presenti nella URL di ogni giocatore che porta alla propria scheda.
Successivamente carica l'elenco di tutti i giocatori presenti nel db di FCM (usando io la skin Revo 2.13 il db è su mysql) e tramite una ricerca ricostruisce l'array di **prob_associazioni.php** stampando a video il l'elenco delle istruzioni da incollare in prob_associazioni.php: il codice visualizzato dalla pagina va AGGIUNTO alla fine del file prob_associazioni.php.

## TODO
- Da verificare se vanno aggiornate le squadre di appartenenza dei giocatori presenti dagli anni precedenti.

## DISCLAIMER

 - Dopo un miglioramento dell'algoritmo di ricerca e confronto credo che ora l'output sia abbastanza preciso: probabilmente ci sono problemi con la presenza di cognomi multipli oltre i due, per esempio ha fatto casini con Martinez che ne sono 3.
 - Fate un backup del file prob_associazioni!!!!
 - potrebbe mancare o essere sbagliata qualche associazione!!!
 - Non mi assumo nessuna responsabilità in caso di perdita di dati
 - CREDO CI SIA ANCORA QUALCHE PROBLEMA, NON SONO SICURO DELLA PRECISIONE DEGLI SCRIPT
