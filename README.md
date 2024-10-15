# FCM-Puffin-prob_associazioni-Builder


**puffin_prob_associazioni_buider.php** e **selectdistinc.php** ricostruiscono il file **prob_associazioni.php** che serve a scaricare le propabiltà di titolarità dei calciatori di serie A nel plugin di FantaCalcioManager **PuffinProbForm**
**CREDO CI SIA ANCORA QUALCHE PROBLEMA, NON SONO SICURO DELLA PRECISIONE DEGLI SCRIPT**

---
Script php per ricostruire da zero il file **prob_associazioni.php** per l'applicativo **PuffinProbForm**

Lo script cerca nella pagina https://www.fantacalcio.it/probabili-formazioni-serie-a tutti i giocatori, ne recupera nome fantagazzetta, codice fantagazzetta e squadra di appartenenza. questi dati sono presenti nella URL di ogni giocatore che porta alla propria scheda.
Successivamente carica anche l'elenco di tutti i giocatori presenti nel db di FCM (usando la skin Revo 2.13 il db è su mysql) e tramite una ricerca ricostruisce l'array di **prob_associazioni.php** stampando a video il l'elenco delle istruzioni incollare in prob_associazioni.php

## DISCLAIMER

 - Dopo un miglioramento dell'algoritmo di ricerca e confronto credo che ora l'output sia abbastanza preciso: probabilmente ci sono problemi con la presenza di cognomi multipli oltre i due, per esempio ha fatto casini con Martinez che ce ne sono 3.
 - Fate un backup del file prob_associazioni!!!!
 - potrebbe mancare o essere sbagliata qualche associazione!!!
 - Non mi assumo nessuna responsabilità in caso di perdita di dati
 - CREDO CI SIA ANCORA QUALCHE PROBLEMA, NON SONO SICURO DELLA PRECISIONE DEGLI SCRIPT
