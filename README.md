# sito-2021
Progettazione di servizi web e reti di calcolatori
Politecnico di Torino
AA 2020-2021 – homework di programmazione
Sviluppare in tecnologia PHP un sito web per gestire le ordinazioni e le consegne di pizze da asporto, organizzato
come segue.
La pagina iniziale (HOME, corrispondente al file home.php) fornisce una presentazione generale del sito.
La pagina di registrazione (REGISTRA) permette ad un nuovo cliente di registrarsi per usufruire del sistema di
prenotazione. La pagina permette all’utente di inserire i dati generali quali nome (campo “name”) , cognome
(campo “surname”), data di nascita (campo “birthdate”), domicilio (campo “address”), credito (campo “money”),
username (campo “nick”) e password (campo “password”). Nome deve essere una stringa di minimo 2 e
massimo 25 caratteri, con solo lettere ed il carattere spazio come caratteri accettabili. Cognome deve essere una
stringa di minimo 2 e massimo 30 caratteri, con solo lettere ed il carattere spazio come caratteri accettabili. Data
di nascita deve essere nella forma “aaaa-mm-gg” (dove il valore 0 in posizione pi`u significativa nel mese e nel
giorno pu`o eventualmente essere omesso). Domicilio deve essere nella forma “Via/Corso/Largo/Piazza/Vicolo
nome numeroCivico”, dove nome pu`o contenere caratteri alfabetici e spazi mentre numeroCivico `e un numero
naturale composto da 1 a 4 cifre decimali. Credito deve essere un valore numerico positivo espresso con la
precisione dei centesimi. Username deve essere una stringa lunga da 3 a 8 caratteri, con solo lettere, numeri e
‘-’ o ‘_’ come valori ammessi e deve cominciare con un carattere alfabetico. Password deve essere una stringa
lunga da 6 a 12 caratteri, che pu`o contenere lettere, numeri e segni di interpunzione, e deve contenere almeno 1
lettera maiuscola, 1 lettera minuscola, 2 numeri, e 2 caratteri di interpunzione.
La pagina di identificazione (LOGIN) permette all’utente di introdurre il suo username e la sua password
per autenticarsi. La pagina contiene due campi testuali per inserire i dati e due bottoni che rispettivamente
cancellano il contenuto di tutti i campi (PULISCI) o li inviano al server per il controllo d’accesso (OK). Se
l’autenticazione fallisce, si rimane nella stessa pagina segnalando l’errore ed invitando l’utente a ritentare il
login.
Facendo accessi successivi alla pagina LOGIN dal medesimo browser (anche in giorni diversi ma nelle 72 ore
successive all’ultimo login), il campo nick deve essere precompilato con l’ultimo valore usato con successo da
quel browser nella pagina LOGIN.
Se l’autenticazione ha successo, l’utente viene indirizzato direttamente alla pagina delle informazioni (INFO)
che fornisce l’elenco delle pizze ordinabili, visualizzandone il nome, gli ingredienti, se il cibo sia vegetariano
o vegano, la quantit`a disponibile ed il prezzo unitario. Se l’utente non si `e autenticato, allora la pagina INFO
fornisce nome, ingredienti, prezzo unitario e se vegetariano o vegano. In entrambi i casi, non devono essere
mostrati prodotti con quantit`a nulla.
La pagina di creazione e aggiornamento pizze (CAMBIA) deve essere accessibile solo ai gestori della pizzeria,
e permette solo ad un utente autenticato di tipo gestore di creare un nuovo prodotto o di alterare la quantit`a di
un prodotto gi`a inserito nel sistema, gli utenti di tipo ’gestore’ sono precaricati nel DB e non possono essere
modificati. La pagina presenta quindi due sezioni. La prima sezione contiene l’elenco dei piatti (con solo nome,
prezzo e quantit`a disponibile) e permette di aggiornare la quantit`a di ciascun prodotto mediante un campo di
testo. L’aggiornamento avviene per singolo prodotto, mediante un tasto apposito a fianco a ciascun prodotto
(Aggiorna prodotto). La seconda sezione permette di inserire un nuovo prodotto nel sistema specificandone il
nome, gli ingredienti, se fruibile da vegetariani o vegani, il costo unitario e la quantit`a disponibile. Se qualcuno
dei dati `e errato, il sistema non deve creare il nuovo prodotto (o alterare i prodotti esistenti) ma segnalare
l’errore restando nella stessa pagina. Se i dati sono corretti, viene modificato il DB come richiesto e segnalato
il successo dell’operazione con una pagina dedicata a questo scopo.
La pagina per le ordinazioni (ORDINA) elenca i piatti disponibili, fornendo per ciascuno di essi il nome, il prezzo
unitario ed un men`u a tendina che permette di selezionare la quantit`a desiderata (da zero alla quantit`a disponibile).
Un pulsante (Annulla) permette di azzerare tutte le quantit`a selezionate mentre un altro pulsante (Procedi)
permette di effettuare l’ordine andando alla pagina CONFERMA. Se l’utente non si `e precedentemente
autenticato tramite la pagina LOGIN, allora la pagine ORDINA presenta solo il seguente avviso:
“Attenzione! questa pagina `e accessibile solo previa autenticazione.”
La pagina CONFERMA deve contenere un riassunto dell’ordine: elenco pizze selezionate, quantit`a che si vuole
ordinare, prezzo unitario di ogni prodotto, prezzo totale di ogni prodotto e importo totale dell’ordine. In questa
pagina `e anche presente un campo per inserire l’indirizzo (campo “deliveryAddress”) a cui si vuole ricevere
l’ordine, e l’ora desiderata di ricezione (campo “deliveryHour”). L’indirizzo (nella stessa forma usata per la
registrazione di un utente) deve essere precompilato con il valore del domicilio dell’utente autenticato ma deve
poter essere modificato. L’ora di consegna deve tenere conto del tempo di preparazione e di logistica, quindi
deve essere almeno 45 minuti dopo il momento dell’ordine.
Un pulsante (OK) permette di confermare l’ordine andando quindi alla pagina FINALE, mentre un altro pulsante
(Annulla) permette di annullare l’ordine tornando alla pagina HOME. Eventuali errori nell’ordine devono
essere chiaramente evidenziati, indicando anche come correggerli e proponendo solo il pulsante Annulla in
caso di errori presenti. La pagina FINALE conferma che l’ordine `e stato accettato ed il relativo costo `e stato
detratto dal credito dell’utente.
Tutte le pagine devono contenere nella medesima posizione un men`u comune per andare alle pagine HOME,
REGISTRA, CAMBIA, INFO, LOGIN ed ORDINA. La voce CAMBIA deve essere sempre presente, ma
attiva solo per utenti gestori. Inoltre il men`u contiene una voce che permette in qualunque momento di uscire
dal sistema (LOGOUT) ossia di tornare anonimi, come prima della procedura di autenticazione. Questa voce
non `e attiva se l’utente non si `e ancora autenticato. Viceversa la voce LOGIN deve essere presente ma non
attiva per un utente autenticato. In tutte le pagine i valori relativi ai prezzi devono essere espressi in Euro con
la precisione dei centesimi (es. un valore di 2.5 Euro deve essere mostrato come 2.50).
Tutto il sito fa riferimento ad un DB in formato MySQL contenente le seguenti tabelle.
La tabella “utenti” contiene i record degli utenti registrati ed `e organizzata su otto campi:
• il campo “nome” `e il nome dell’utente;
• il campo “cognome” `e il cognome dell’utente;
• il campo “data” `e la data di nascita dell’utente, nella forma “aaaa-mm-gg”;
• il campo “indirizzo” `e il domicilio dell’utente registrato, e pu`o cominciare solo con una delle cinque
parole “Via”, “Corso”, “Largo”, “Piazza”, “Vicolo” seguito dal nome della via e dal suo numero civico
(es. “Corso Duca degli Abruzzi 24”);
• il campo “credito” `e il credito dell’utente ed `e un numero intero pari all’importo in centesimi del denaro
presente nel borsellino elettronico dell’utente (es. un utente con 20 Euro nel borsellino avr`a questo campo
col valore 2000);
• il campo “username” `e l’identificativo dell’utente ed `e la chiave primaria;
• il campo “pwd” `e la password dell’utente;
• il campo “gestore” `e un campo Booleano che indica se l’utente sia un gestore o meno.
Inoltre il DB contiene la tabella “pizze” con record organizzati su sei campi:
• il campo “id” `e un numero intero che identifica univocamente il record, ossia `e la chiave primaria;
• il campo “nome” contiene il nome della pizza;
• il campo “ingredienti” contiene gli ingredienti della pizza (testo in formato libero);
• il campo “tipo” specifica che la pizza sia vegetariana o vegana, e pu`o contenere solo i valori “veggy” per
vegetariano, “vegan” per vegano, o essere vuoto per le pizze che non sono n´e vegane n´e vegetariane;
• il campo “prezzo” contiene il prezzo unitario della pizza ed `e un numero intero pari all’importo in
centesimi di Euro (es. un presso di 6.50 Euro deve essere memorizzato come 650);
• il campo “qty” contiene il numero di pizze preparabili per quella tipologia di pizza, `e un numero intero.
Tutte le pagine devono contenere nella medesima posizione in alto a destra lo username dell’utente ed il credito
che ha attualmente, rispettivamente pari ad “ANONIMO” e zero se l’utente non si `e ancora autenticato.
Il sito deve essere impaginato e formattato in modo coerente in tutte le pagine che devono avere lo stesso stile
grafico facilmente controllabile mediante un foglio di stile.
Ogni pagina deve contenere – come dati comuni e facilmente modificabili – un header (col nome del sito) ed un
footer (che indica il nome del file e l’autore della pagina). Ove possibile e sensato, queste informazioni devono
essere calcolate automaticamente.
Il sito deve essere installabile in una qualunque cartella di un server web; le pagine non devono quindi avere
dipendenze da path o indirizzi di rete specifici.
Tutti i contenuti devono essere aderenti agli standard W3C e nello sviluppo del sito si devono mettere in pratica
le norme di buona programmazione web apprese a lezione.
Nell’accesso al DB si richiede di minimizzare i privilegi assegnati a ciascuna pagina, usando in modo opportuno
i due utenti predefiniti nel DB (“uWeak” e “uStrong”); si noti inoltre che non `e permesso usare l’utente “admin”
o altri utenti non definiti nel DB fornito
Istruzioni di consegna: una volta terminato lo sviluppo del sito all’interno della propria area personale sull’ambiente
cloud del corso, inviare una mail al docente per segnalare la richiesta di valutazione. La mail deve
essere spedita dal sistema di posta del Politecnico, avere come Subject il testo “PWR / richiesta valutazione
sito web” e nel corpo della mail devono essere indicati nome, cognome e matricola del richiedente, nonch´e la
cartella (all’interno della propria area personale sull’ambiente cloud del corso) dove `e situata la radice del sito
web sviluppto (ovvero la cartella dove `e collocato il file home.php).
Una volta ricevuta la mail, l’area personale verr`a bloccata e non sar`a pi`u possibile apportare modifiche. L’esito
della valutazione del sito verr`a comunicato via mail.
