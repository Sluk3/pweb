# Documentazione Tecnica - Piattaforma Produttore Musicale

## Indice
1. [Introduzione](#introduzione)
2. [Dominio Applicativo](#dominio-applicativo)
3. [Requisiti Funzionali](#requisiti-funzionali)
4. [Schema ER](#schema-er)
5. [Vincoli della Base di Dati](#vincoli-della-base-di-dati)
6. [Architettura del Sistema](#architettura-del-sistema)
7. [Tecnologie Utilizzate](#tecnologie-utilizzate)
8. [Sicurezza](#sicurezza)

## Introduzione
Il progetto consiste nella realizzazione di una piattaforma web per un produttore musicale professionista. La piattaforma serve come vetrina professionale per il portfolio dell'artista e come e-commerce per la vendita di prodotti e servizi musicali digitali. Il sistema permette la gestione autonoma dei contenuti da parte del produttore e offre un'esperienza di acquisto fluida per i clienti.

## Dominio Applicativo

### Contesto Generale
Il settore della produzione musicale moderna è fortemente digitalizzato, con un mercato in crescita per quanto riguarda la vendita di contenuti digitali come beat, sample pack e servizi di post-produzione. I produttori musicali necessitano di piattaforme personalizzate per:
- Presentare il proprio lavoro in modo professionale
- Vendere direttamente i propri prodotti digitali
- Gestire le richieste di servizi come mixing e mastering
- Costruire un brand personale nel settore musicale

### Prodotti e Servizi Offerti
1. Beat
   - Composizioni musicali complete pronte per essere utilizzate
   - Disponibili in diversi formati (WAV, MP3)
   - Possibilità di licenze diverse (esempio: base, premium, esclusiva)

2. Sample Pack
   - Collezioni di suoni originali
   - Utilizzabili per produzioni musicali
   - Categorizzati per genere o tipo di suono

3. Servizi Audio
   - Mixing: processo di bilanciamento e ottimizzazione delle tracce
   - Mastering: finalizzazione professionale del brano
   - Prezzi personalizzabili in base alla complessità del progetto

### Utenti Target
1. Artisti e Musicisti
   - In cerca di beat per i propri progetti
   - Necessitano di servizi di mixing e mastering

2. Produttori Musicali
   - Interessati all'acquisto di sample pack
   - Potrebbero richiedere servizi di post-produzione

3. Content Creator
   - Necessitano di musica per i propri contenuti
   - Interessati principalmente ai beat

## Requisiti Funzionali

### Funzionalità Obbligatorie

1. Landing Page e Portfolio
   - Sezione di presentazione del produttore
   - Portfolio dei lavori realizzati
   - Player audio per l'ascolto dei sample
   - Showcase dei progetti più significativi
   - Sezione testimonial/feedback clienti

2. Sistema di Autenticazione
   - Registrazione nuovo utente
   - Login utente esistente
   - Recupero password
   - Gestione profilo utente

3. E-commerce
   - Catalogo prodotti digitali
   - Pagine dettaglio prodotto con preview audio
   - Sistema di prezzi e licenze
   - Metodi di pagamento sicuri

4. Area Amministrativa (Produttore)
   - Gestione utenti
   - Gestione prodotti
   - Statistiche vendite
   - Gestione ordini
   - Upload nuovi contenuti

5. Footer e Contatti
   - Form di contatto
   - Collegamenti social media
   - Informazioni legali e privacy
   - FAQ e supporto

### Funzionalità Opzionali

1. Sistema Carrello
   - Aggiunta/rimozione prodotti
   - Calcolo totale
   - Gestione quantità
   - [In sviluppo] Conferma ordine

2. Area Download Gratuiti
   - Sezione dedicata ai contenuti gratuiti
   - Sistema di download per utenti registrati
   - Rotazione periodica dei contenuti

## Schema ER
[Questa sezione verrà completata dopo l'accesso al file SQL nella repository]

### Entità Principali
1. Utenti
2. Prodotti
3. Ordini
4. Downloads
5. [Altre entità presenti nel database]

## Vincoli della Base di Dati

### Vincoli di Integrità
1. Ogni prodotto deve avere un prezzo valido
2. Ogni utente deve avere un email unica
3. Gli ordini devono essere associati a utenti registrati
4. I download gratuiti devono avere un periodo di disponibilità definito

### Vincoli di Business
1. Un utente non può acquistare lo stesso prodotto digitale più volte
2. I prezzi dei servizi di mixing/mastering devono essere concordati individualmente
3. I download gratuiti sono disponibili solo per utenti registrati
4. Le preview audio devono essere in formato compresso e durata limitata

## Architettura del Sistema

### Stack Tecnologico
- Frontend: HTML, CSS
- Backend: PHP
- Database: MySQL
- File System: Gestione file audio e download

### Pattern Architetturali
- MVC per la struttura generale dell'applicazione
- Repository Pattern per l'accesso ai dati
- Singleton per la gestione delle connessioni al database

## Tecnologie Utilizzate
- PHP 8.x
- MySQL 8.x
- HTML5
- CSS3
- JavaScript per la riproduzione audio
- Git per il controllo versione

## Sicurezza
1. Gestione Accessi
   - Autenticazione utenti
   - Sessioni sicure
   - Protezione area amministrativa

2. Protezione Dati
   - Crittografia password
   - Validazione input
   - Prevenzione SQL injection

3. Protezione Contenuti
   - Sistema di licenze
   - Protezione file audio
   - Download sicuri
   - Watermark audio per le preview

## Schema ER

### Entità e Attributi

1. User
   - username (PK): varchar(20)
   - mail: varchar(255)
   - pwd: varchar(255)
   - admin: tinyint(1)
   - authorized: tinyint(1)
   - blocked: tinyint(1)

2. Product
   - id (PK): varchar(10)
   - title: varchar(50)
   - type_id (FK): int
   - descr: text
   - bpm: int (nullable)
   - tonality: varchar(3) (nullable)
   - genre: varchar(20) (nullable)
   - num_sample: int (nullable)
   - num_tracks: int (nullable)
   - audiopath: varchar(255) (nullable)

3. Type
   - id (PK): int
   - name: varchar(20)
   - descr: text

4. List_Head
   - id (PK): int
   - descr: text

5. List_Prices
   - id (PK): int
   - price: float
   - date: datetime
   - prod_id (FK): varchar(10)
   - list_id (FK): int

6. Order_Head
   - id (PK): int
   - username (FK): varchar(20)
   - date: datetime
   - confirmed: tinyint(1)

7. Order_Detail
   - order_id (PK, FK): int
   - prod_id (PK, FK): varchar(10)
   - cur_price: float
   - quantity: int

### Relazioni

1. Product - Type (N:1)
   - Ogni prodotto appartiene a un tipo
   - Un tipo può essere associato a più prodotti

2. Product - List_Prices (1:N)
   - Ogni prodotto può avere multiple variazioni di prezzo nel tempo
   - Ogni prezzo è associato a un solo prodotto

3. List_Prices - List_Head (N:1)
   - Ogni prezzo appartiene a un listino
   - Un listino può contenere più prezzi

4. User - Order_Head (1:N)
   - Un utente può effettuare più ordini
   - Ogni ordine appartiene a un solo utente

5. Order_Head - Order_Detail (1:N)
   - Un ordine può contenere più prodotti
   - Ogni dettaglio ordine appartiene a un solo ordine

6. Product - Order_Detail (1:N)
   - Un prodotto può essere presente in più ordini
   - Ogni dettaglio ordine si riferisce a un solo prodotto

## Vincoli della Base di Dati

### Vincoli di Integrità Referenziale
1. Product.type_id → Type.id
   - ON DELETE CASCADE
   - ON UPDATE CASCADE

2. List_Prices.prod_id → Product.id
   - ON DELETE CASCADE
   - ON UPDATE CASCADE

3. List_Prices.list_id → List_Head.id
   - ON DELETE CASCADE
   - ON UPDATE CASCADE

4. Order_Detail.order_id → Order_Head.id
   - ON DELETE CASCADE
   - ON UPDATE CASCADE

5. Order_Detail.prod_id → Product.id
   - Senza clausole CASCADE

6. Order_Head.username → User.username
   - Senza clausole CASCADE

### Vincoli di Dominio
1. User
   - admin, authorized, blocked sono booleani (tinyint(1))
   - email deve essere un indirizzo valido
   - username deve essere unico

2. Product
   - bpm deve essere un numero positivo quando specificato
   - num_sample e num_tracks devono essere positivi quando specificati

3. List_Prices
   - price deve essere un numero positivo o zero
   - date non può essere nel futuro

4. Order_Head
   - confirmed è un booleano (tinyint(1))
   - date viene impostata automaticamente al timestamp corrente

5. Order_Detail
   - quantity deve essere maggiore di zero
   - cur_price deve essere non negativo

### Vincoli di Business
1. Gestione Utenti
   - Solo gli utenti autorizzati (authorized=1) possono effettuare acquisti
   - Gli utenti bloccati (blocked=1) non possono accedere al sistema
   - Gli amministratori (admin=1) hanno accesso a tutte le funzionalità

2. Gestione Prodotti
   - Ogni prodotto deve appartenere a una categoria valida (type)
   - I campi specifici (bpm, tonality, genre) sono obbligatori per i beat
   - Il campo num_sample è obbligatorio per sample pack e drum kit

3. Gestione Ordini
   - Un ordine non confermato (confirmed=0) può essere modificato
   - Un ordine confermato non può essere modificato
   - Il prezzo corrente (cur_price) viene fissato al momento dell'inserimento nel carrello
