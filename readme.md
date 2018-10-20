## My Console Based Social Network for XPeppers

Per poter utilizzare l'applicazione si deve copiare il file .env.example rinominandolo in .env e modificare i dati per la connessione al DB Mysql con quelli del vostro DB.

Importare quindi la struttura del DB tramite il file .sql che ho inserito nella root principale dell'app.

Installazione completata.

## USAGE

Puntando il browser nella cartella public si aprirà una pagina di benvenuto dove è possibile creare nuovi utenti , o loggarsi con un utente già creato in precedenza (non era richiesto ma l'ho fatto per completezza ed è comprensivo di controlli per la validazione dati e controllo per evitare l'inserimento di un utente già presente in DB).

Una volta loggati si accede quindi alla pagina personale dove sarà possibile inviare i comandi di posting, reading, following, wall. Anche se non richiesto ho gestito tutte le eccezioni sull'inserimento errato di comandi.

Inoltre ho aggiunto altre funzionalità, non richieste, tipiche dei social network come il ti piace, non ti piace, la modifica e la cancellazione del post (funziona solo per i post scritti dell'utente loggato).

