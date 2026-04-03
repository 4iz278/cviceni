# 8. SQL a databáze

- většina webových aplikací má svá data uložená v databázi
- reálně se používají jak relační databáze, tak NoSQL - v rámci tohoto kurzu se omezíme na běžné relační databáze
  - konkrétně budeme používat MariaDB

## Základní SQL příkazy pro manipulaci
:point_right:

Předpokládám, že za sebou máte základní kurz věnovaný databázím, tj. SQL v zásadě umíte a základní vlastnosti relačních databází znáte.

Budeme používat databázi MariaDB, která vychází z MySQL. Základní SQL příkazy (SELECT, INSERT, UPDATE, DELETE) jsou ale obdobné napříč většinou relačních databází.

**Co se po vás bude v tomto předmětu chtít?**
- příkazy pro CRUD operace, tj. ```SELECT```, ```INSERT```, ```UPDATE```, ```DELETE```
- umět logicky navrhnout strukturu databáze (a vytvořit ji např. pomocí phpMyAdminu)
- vědět, jak se chovají cizí klíče
- vědět, co jsou to transakce

**Co se po vás naopak chtít nebude?**
- vytváření a úprava tabulek, views atp.
    - v praxi se struktura databáze často spravuje pomocí nástrojů s grafickým rozhraním nebo migračních skriptů
- definice triggerů, uložených funkcí a dalších pokročilých funkcionalit (samozřejmě je můžete používat, ale jde to i bez nich)


:point_right:

Pro jednoduché ověření - zvládli byste říct, co dělají následující příkazy?

```mysql
SELECT * FROM osoby;
SELECT jmeno, prijmeni FROM osoby LEFT JOIN zamestnani ON osoby.id=zamestnani.osoba WHERE stav=1 ORDER BY prijmeni, jmeno LIMIT 10 OFFSET 100;
INSERT INTO osoby(jmeno, prijmeni, stav) VALUES ('Pepa', 'Novák', 1);
UPDATE osoby SET stav=0 WHERE prijmeni LIKE '%Nov%';
DELETE FROM osoby WHERE stav=0;
TRUNCATE TABLE osoby;
```

:blue_book:

- [MySQL tutoriál na w3schools.com](https://www.w3schools.com/mysql/)
- pár komentovaných příkladů:
    - [create table](08-ukazky-sql/1-create-table.sql)
    - [insert](08-ukazky-sql/2-insert.sql)
    - [select](08-ukazky-sql/3-select.sql)
    - [update](08-ukazky-sql/4-update.sql)
    - [transactions](08-ukazky-sql/5-transactions.sql)
    - [delete](08-ukazky-sql/6-delete.sql)
    - [cascade](08-ukazky-sql/7-cascade.sql)

    
## MySQL a MariaDB
:point_right:

- MySQL a MariaDB jsou patrně nejčastěji používanými databázemi v kombinaci s PHP.
    - Z historického hlediska se MySQL rozšířilo z důvodu svobodné licence, jednoduchosti a rychlosti.
    - databáze se obvykle instalovala rovnou v kombinaci s Apachem a PHP
    - původně šlo o jednoduchou databázi, která kdysi ani nepodporovala cizí klíče
- dnes jde o plnohodnotnou a výkonnou databázi, která podporuje všechny běžné konstrukty
- MySQL je majetkem Oracle, MariaDB je její open source větev.
    - pro běžné aplikace mezi nimi není zásadní rozdíl

### Databáze na serveru eso.vse.cz
:point_right:

Na serveru eso.vse.cz máte každý zřízenou osobní databázi. Heslo pro připojení k ní najdete po přihlášení na server ve svém domovském adresáři, v souboru **mysql-heslo.txt**.
Připojte se tedy k serveru a stáhněte/zkopírujte si heslo. Následně jej použijeme jak pro přihlášení pomocí phpMyAdminu, tak také ve vlastní aplikaci. 

:grey_exclamation: Jako první operaci po připojení k databázi bude potřeba změnit její výchozí kódování na **utf8mb4**. 

### Typy tabulek
:point_right:

Při vytváření tabulek je nutné si vybrat *úložiště*. Konkrétně se v praxi používají 2:
- InnoDB = úložiště s podporou cizích klíčů, doporučuji jej používat jako základní
- MyISAM = historické úložiště bez podpory cizích klíčů, ale stále jej v některých aplikacích najdeme  

### Datové typy, kódování, klíče
:point_right:

Při vytváření sloupců v tabulkách máme na výběr několik **základních datových typů**. Když vytváříte tabulku v phpMyAdminu (viz dále), tak vám zobrazí nápovědu, k čemu se který datový typ hodí.
- INT = základní typ pro celá čísla
- FLOAT, DOUBLE = desetinná čísla s plovoucí desetinnou částkou
- DECIMAL = číslo s pevným počtem desetinných míst -> vhodné pro částky
- VARCHAR = textový řetězec o maximálně zadané délce; pokud je řetězec kratší, zabere v paměti jen tolik místa, kolik nutně potřebuje
- TEXT = datový typ pro velká textová data 
- DATE = datum ve tvaru yyyy-mm-dd
- TIMESTAMP = klasický timestamp, jeho specialitou je to, že se jeden sloupec s tímto typem umí automaticky aktualizovat při každé změně v daném řádku (tj. hodí se to pro automatické sledovní poslední změny záznamu) 
- ENUM, SET = datové typy s konkrétním výčtem hodnot -> vhodné např. pro pohlaví, stavy objednávky atp. Rozhodně je vhodnější používat ENUM nebo SET, než např. stavy objevnávky mít označené číslem.
- JSON = datový typ pro ukládání strukturovaných dat ve formátu JSON (např. pole nebo objekty); vhodné např. pro flexibilní konfiguraci nebo data bez pevné struktury
    
Specifika datových typů:
- MariaDB nezná datový typ BOOLEAN. Místo něj používá *INT(1)*, do kterého pak ukládáte 1 nebo 0.
- Pokud budete chtít v některém sloupci NULL hodnoty, musíte je extra povolit.


:point_right:

**Pozor na kódování!**
- Specifikem MariaDB je to, že každá tabulka i každý její sloupec může používat jiné kódování. V praxi to ale neděláme, pokud to není vyloženě nutné, protože pak musíme všechny dotazy i jejich odpovědi překódovávat!
  - ideální sjednoťte kódování databáze, tabulek, jednotlivých sloupců i připojení z PHP 
- Doporučuji používat MariaDB normálně s kódováním *utf8mb4*, způsob řazení si pak můžete vybrat z dané nabídky. Např. *utf8mb4_czech_ci*.        


:point_right:

**Typy indexů/klíčů**
- PRIMARY = primární klíč tabulky
- UNIQUE = vyžadování unikátních hodnot, ale nejde o primární klíč
- INDEX = běžné indexování hodnot (zrychluje vyhledávání, ale o něco zpomaluje ukládání)
- FULLTEXT = klíč s fulltextovým indexem (vyhledávání v textu)

Klíče můžete definovat nad jedním či nad více sloupci, stejně jako v Oracle.

:grey_exclamation: Jedna praktická rada: Ačkoliv jste se v databázích učili, že když je to možné, máte používat složené klíče, ve webových aplikacích občas "zbytečně" zavádíme umělé primární klíče s autoincrementem. Důvody jsou poměrně jednoduché:
- v odkazech atp. vypadá mnohem lépe a srozumitelněji jedno číslo, než několik různých hodnot
- neměli bychom uživatelům ukazovat hodnoty, které nepotřebují vidět (např. osobní údaje osob atp.) 


## phpMyAdmin
:point_right:

- phpMyAdmin je komplexní webový nástroj pro práci s MySQL/MariaDB, přičemž je napsaný v PHP a nalezneme ho na většině serverů
- umožňuje nám jednoduše prohlížet a upravovat nejen data, ale i strukturu databáze     

### phpMyAdmin na serveru eso.vse.cz
:point_right:
- phpMyAdmin na serveru eso najdete na adrese **[https://eso.vse.cz/myadmin/](https://eso.vse.cz/myadmin/)**

:orange_book:
- [prezentace s popisem phpMyAdminu](./08-prezentace-phpmyadmin.pptx) 


## Jiné přístupy k databázi
:point_right:

K databázi můžete samozřejmě přistupovat nejen pomocí phpMyAdminu, ale také pomocí IDE, konzole a spousty dalších nástrojů.

### Adminer
:point_right:
- Jde o jednoduché rozhraní pro náhled do dabáze, zejména v situaci, kdy ji nechceme/nemůžeme zpřístupnit pomocí komplexnějšího nástroje.
- Obrovskou výhodou je to, že jde vlastně jen o jeden malý PHP soubor, který můžete nahrát na libovolný hosting s PHP.
- Kromě MariaDB podporuje i celou řadu dalších databází, včetně objektových.
- Nástroj má 2 varianty: *Adminer* a *Adminer Editor* - první z nich zpřístupňuje jen data, druhý umožňuje i naklikat strukturu databáze.  

**Doporučuji vám si tento nástroj vyzkoušet a zapamatovat, protože je to nejjednodušší možný způsob, jak se dostat do databáze, i když není přístupná mimo server.**

:blue_book:
- oficiální web nástroje: [https://www.adminer.org/cs/](https://www.adminer.org/cs/)

---

## Připojení k databázi z PHP
:point_right:

Připojení k MySQL/MariaDB je z PHP možné hned několika metodami. Mezi běžné způsoby lze zařadit:
- připojení pomocí PDO
  - tento způsobu doporučuji, jde o standardní variantu
  - s touto možností budeme řešit příklady na cvičeních
- připojení pomocí mysqli funkcí
  - pozor, je opravdu nutné používat funkce začínající na mysqli (ne na mysql)
  - i zde je možné používat prepared statements (doporučeno)

        
:point_right:
        
Kromě přímého připojení můžete využít také nějakou abstraktní vrstvu - ať již pro jednodušší tvorbu dotazů, nebo pro objektově relační mapování.
- Řada PHP frameworků či CMS v sobě obsahuje i databázovou vrstvu:
    - v Nette, Laravelu atp. můžete buď používat připojení pomocí tříd frameworku, nebo použít libovolný jiný způsob připojení (např. s ORM);
    - vlastní připojení najdete také v nejrozšířenějších CMS - např. ve wordpressu.
- Pro objektově-relační mapování lze používat např. [Doctrine](https://www.doctrine-project.org/), nebo jednodušší [Leanmapper](https://leanmapper.com/).    

### Co je to PDO?
:point_right:

- PDO ("PHP Data Objects") je standardní rozhraní pro práci s databázemi v PHP.
- V zásadě jde o základní abstrakční vrstvu, díky které nemusíme řešit, jaké konkrétní funkce pracují s daným typem databáze. Po instalaci příslušných ovladačů se můžeme dotazovat pořád stejně pomocí PDO. Je nutné ale mít na paměti, že:
- PDO nijak nemění SQL dotazy, které chceme spustit - tj. pokud chceme aplikaci převést např. z MariaDB do MS SQL, budeme muset dotazy upravit (protože se dané varianty SQL neshodují).
- Ovladače pro MariaDB/MySQL najdeme většinou rovnou nainstalované, ale např. pro Oracle obvykle ne. PDO se ale umí připojit k databázi i pomocí ODBC.
- PDO podporuje tzv. prepared statements (připravené dotazy), které chrání aplikaci proti SQL injection – jde o doporučený způsob práce s databází
    - při jejich použití se hodnoty do dotazu nevkládají přímo, ale předávají se odděleně
- Nad PDO je postaveno také velké množství vyšších abstraktních vrstev a knihoven, např. pro ORM.


:blue_book:
- [PDO v PHP manuálu](https://www.php.net/manual/en/book.pdo.php)

### Připojení k databázi
:point_right:

Pro připojení k databázi stačí vytvořit instanci třídy PDO s příslušnými parametry.
- Z praxe doporučuji si danou proměnnou pojmenovat tak, aby bylo na první pohled zřejmé, o co jde. Např. ```$db``` nebo ```$pdo```.
- **K jedné databázi se připojujeme vždy jen jednou!**
    - V opačném případě bychom zbytečně zabírali sockety pro možná připojení a zároveň výrazně zpomalovali skript.
- Odpojení od databáze nijak řešit nemusíte, dojde k němu při zrušení databázového objektu. Tj. automaticky při konci aplikace.

:grey_exclamation: Je vhodné mít připojení k databázi definované v celé aplikaci jen v jednom souboru - buď rovnou vytvoření instance PDO, nebo nějaké konstanty s přístupy. Z bezpečnostních důvodů určitě časem dojde ke změně přístupů a rozhodně není rozumné hledat a měnit např. heslo k DB ve spoustě různých souborů.

```php
//připojení do DB na serveru eso.vse.cz - XNAME a HESLO samozřejmě zaktualizujte dle svých vlastních údajů
//doporučuji do connection stringu rovnou dopsat také údaje o kódování, ve kterém chceme s databází komunikovat
$db = new PDO('mysql:host=127.0.0.1;dbname=XNAME;charset=utf8mb4', 'XNAME', 'VASE HESLO DO MYSQL');

//následující nastavení zařídí, abychom byla při chybě v SQL vyhozena standardní výjimka (exception)
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

- praktický tip - pokud obvykle budete chtít pracovat s výsledky ve formě asociačních polí, jde nastavit připojení k DB i podrobněji (buď pomocí metody setAttribute, nebo rovnou v konstruktoru)
```php
//připojení do DB na serveru eso.vse.cz - XNAME a HESLO samozřejmě zaktualizujte dle svých vlastních údajů
$db = new PDO(
  'mysql:host=127.0.0.1;dbname=xname;charset=utf8mb4',
  'xname',
  'vaše heslo do mysql',
  [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // vyhazování výjimek při chybě
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // výchozí fetch jako asociativní pole
    PDO::ATTR_EMULATE_PREPARES => false, // použití nativních prepared statements
  ]
);
```

### Spouštění SQL příkazů
:point_right:

**Jednoduché spuštění SQL dotazu bez požadavku na odpověď**

Pokud chceme spustit SQL dotaz, u kterého neočekáváme žádné konkrétní výsledky, je nejjednodušší spustit jen pomocí metody ```exec()```.

```php
$db->exec('TRUNCATE TABLE tabulka;');
```


:point_right:

**Spuštění SQL dotazu bez uživatelských vstupů**

Pro získání dat pomocí SQL můžeme použít metodu ```query()```. Jejím výsledkem bude **PDOStatement**, pomocí kterého se dostaneme k výsledkům.

```php
$result = $db->query('SELECT * FROM tabulka;');
$data = $result->fetchAll();
```


:point_right:

**SQL dotaz s parametry**

Pokud chceme spustit SQL dotaz, ve kterém mají být zahrnuta nějaká data získaná od uživatele či z jiného potenciálně nebezpečného zdroje, tak z důvodu ochrany proti SQL injection použijeme **prepared statement**.


:point_right:

První variantou je **dotaz s pojmenovanými parametry**:

```php
$query = $db->prepare('SELECT * FROM osoby WHERE jmeno=:jmeno AND prijmeni=:prijmeni;');//nejprve si připravíme dotaz s parametry
$query->execute([//následně naplníme parametry dotazu konkrétními hodnotami a spustíme
  ':jmeno' => $jmeno,
  ':prijmeni' => $prijmeni
]);
```  

Jméno každého z parametrů musí začínat dvojtečkou.

Kromě předání pole parametrů při spuštění dotazu bychom alternativně  mohli připojit parametry také postupně, pomocí metod ```$query->bindParam()``` a ```$query->bindValue()```.


:point_right:

Druhou variantou je **dotaz s nepojmenovanými parametry**:

```php
$query = $db->prepare('SELECT * FROM osoby WHERE jmeno=? AND prijmeni=?;');//nejprve si připravíme dotaz s parametry
$query->execute([
  $jmeno,
  $prijmeni
]);
``` 
V tomto případě je každý z parametrů označen otazníkem. Při jejich naplnění musíme dodržovat pořadí parametrů v poli podle toho, jak byly uvedeny v SQL.


:point_right:

**PDOStatement**
- Po spuštění jednoduchého dotazu pomocí metody ```query()``` nebo po *spuštění prepared statementu* máme k dispozici instanci třídy PDOStatement, která nám následně umožní vyzvednout výsledky dotazu z databáze.
- První variantou, která se hodí zejména v případě zpracování menšího množství dat, je **jednorázové získání pole se všemi výsledky**:

```php
$query = $db->query('SELECT * FROM osoby;');
$osoby = $query->fetchAll(PDO::FETCH_ASSOC);//každý z řádků DB tabulky získáme v podobě asociačního pole; alternativně bychom mohli získat pole s číselnými indexy, nebo objekty

if (!empty($osoby)){
  foreach ($osoby as $osoba){
    echo $osoba['jmeno'];  
  }
}
```

- V případě, že bychom chtěli jen hodnoty z jednoho sloupce (např. ID osob), lze použít:
```php
$query = $db->query('SELECT id FROM osoby;');
$arr = $query->fetchAll(PDO::FETCH_COLUMN);
```

:point_right:

- Druhou variantou je **postupné načítání jednotlivých řádků**.
  - Tato varianta je paměťově úspornější při zpracování většího množství dat.

```php
$query = $db->query('SELECT * FROM osoby;');
while ($osoba = $query->fetch(PDO::FETCH_ASSOC)){ //načteme jeden řádek z výsledků SQL dotazu v podobě asociačního pole
  echo $osoba['jmeno'];
}
```

```php
$query = $db->query('SELECT * FROM osoby;');
while ($osoba = $query->fetchObject()){ //načteme jeden řádek z výsledků SQL dotazu v podobě objektu (jako parametr funkce fetchObject() je možné zadat i název třídy, jejíž instanci chceme)
  echo $osoba->jmeno;
}
```

- v případě, že chceme jen jednu hodnotu:
```php
$query = $db->query('SELECT id FROM osoby;');
while ($id = $query->fetchColumn()){ //načteme hodnotu z jednoho sloupce, pokud bychom jich měli ve výsledku více, lze použít číselný index (např. fetchColumn(0))
  echo $id;
}
```

:point_right:

- Poslední základní variantou je to, že nás zajímá jen **počet řádků** výsledku - ale pozor, u SELECTu to nemusí být vždy spolehlivé.
  - Pokud řádky s výsledky nechceme, použijeme v SQL funkci count()

```php
$query = $db->query('SELECT * FROM osoby;');
echo $query->rowCount();
```


:blue_book:

Další zdroje informací:

- [Prepared statement - PHP manuál k PDO](https://www.php.net/manual/en/pdo.prepared-statements.php)
- [Transakce - PHP manuál k PDO](https://www.php.net/manual/en/pdo.transactions.php)
- [PDOStatement - PHP manul k PDO](https://www.php.net/manual/en/class.pdostatement.php)


## Tvorba aplikace využívající databázi
:orange_book:

V rámci praktické ukázky si projdeme tvorbu aplikace, která bude sloužit jako **jednoduchá webová nástěnka s daty uloženými v databázi**. 
Na nástěnce bude možné mít umístěné příspěvky přiřazené do kategorií, každý příspěvek bude mít svého autora. 

* [prezentace s komentovaným postupem řešení](08-aplikace-nastenka/prezentace-postup-vyvoje-nastenka.pptx)
* [vytvořený zdrojový kód včetně exportu databáze](08-aplikace-nastenka/)


## Další ukázková aplikace pracující s databází
S ohledem na to, že budeme pracovat s databází až do konce předmětu, je vhodné si práci s ní procvičit i na další aplikaci:

:blue_book:
- postup zprovoznění ukázkové aplikace:
    1. stáhněte si celou složku aplikace ([08-db-app-clients](./08-db-app-clients)) a nahrajte ji na server
    2. nahrajte do MariaDB [strukturu databáze](./08-db-app-clients/db-schema.sql)
    3. nahrajte do MariaDB [ukázková data](./08-db-app-clients/db-data.sql)
    4. nastavte vlastní xname a heslo k databázi v souboru [db.php](./08-db-app-clients/db.php)
- ukázkové skripty v aplikaci:
    - [jednoduchý výpis klientů](./08-db-app-clients/index.php)
    - [výpis klientů se stránkováním](./08-db-app-clients/index_with_pagination.php)
    - [vytvoření nového klienta](./08-db-app-clients/new_prepare.php)
    - [vytvoření nového klienta - bez ošetření SQL injection](./08-db-app-clients/new_open.php)
    - [úprava klienta](./08-db-app-clients/update.php)
    - [smazání klienta](./08-db-app-clients/delete.php)    
