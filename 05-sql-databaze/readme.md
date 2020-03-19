# 5. SQL a databáze

:grey_exclamation: **Tato složka obsahuje podklady k domácímu studiu ke cvičením 26. a 20.3.2020.**
Oproti běžným podkladům ke cvičením zde naleznete podrobnější vysvětlení dané problematiky a další příklady.

## Opakování z minulého cvičení

:point_right:

V rámci [minulého cvičení](../04-objekty-II-validace) byla dokončena problematika používání objektů v PHP, druhá část podkladů pak byla věnována problematice validace formulářů.


:point_right:

Z hlediska **práce s objekty** byste si měli pamatovat:
- již ze 3. cvičení základní informace o definici a používání tříd, jmenných prostorů, rozhraní, dědičnosti, traitů
- z minulého cvičení navíc *magické metody*:
    - všechny začínají na __ (dvě podtržítka) 
    - jsou volány buď v případě speciálních úkonů (konstruktor, převod na string, serializace),
    - nebo umí simulovat neexistující/zpřístupnit private proměnné či metody. 
- *classloader* a *composer*:
    - běžně nenačítáme soubory s definicí tříd ručně pomocí require/include, ale definujeme funkci, která je načte při jejich prvním použití;
        - buď ruční definice pomocí ```spl_autoload_register```,
        - nebo načítání v rámci nějakého frameworku.
    - závislosit načítáme nástrojem *composer*
        - definice pomocí jednoduchého JSON souboru, ve kterém uvedeme, jaké komponenty chceme;
        - composer načítá komponenty buď z https://packagist.org, nebo z GITu;
        - pro načtení všech příslušných tříd stačí načíst vygenerovaný autoload.php.


:point_right:

Z hlediska **validace formulářů**:
- musíme kontrolovat všechna data získaná od uživatele (ať jsme je získali z formuláře, v parametrech v URL či například z nějakého API)!
- u formuláře je sice hezké definovat kontrolu v HTML 5 a v javascriptu, ale stejně musíme kontrolovat data i na serveru,
- uživateli musíme zobrazit konkrétní popisy chyb (buď na jednom místě, nebo u konkrétních polí formuláře), správná data musí zůstat ve formuláři vyplněna;
- po odeslání formuláře metodou POST musí následovat přesměrování pomocí ```header('Location: soubor.php');```

:house:

Připomínám, že součástí byl také [domácí úkol](../04-objekty-II-validace#dom%C3%A1c%C3%AD-%C3%BAkol). Pokud jej máte hotový, nezapomeňte na jeho odevzdání.

---

:point_right:

**Na tomto cvičení nás čeká:**
- [opakování základních SQL příkazů pro manipulaci s daty](#z%C3%A1kladn%C3%AD-sql-p%C5%99%C3%ADkazy-pro-manipulaci)
- [vlastnosti MySQL a MariaDB](#mysql-a-mariadb)
- [databáze na serveru eso.vse.cz](#datab%C3%A1ze-na-serveru-esovsecz)
- [práce s nástrojem phpMyAdmin](#phpmyadmin) a [jiné přístupy k databázi](#jin%C3%A9-p%C5%99%C3%ADstupy-k-datab%C3%A1zi)
- [připojení k databázi z PHP](#p%C5%99ipojen%C3%AD-k-datab%C3%A1zi-z-php)
- [praktická aplikace využívající databázi](#praktick%C3%A1-aplikace-vyu%C5%BE%C3%ADvaj%C3%ADc%C3%AD-datab%C3%A1zi)  

---        

## Základní SQL příkazy pro manipulaci
:point_right:

Předpokládám, že za sebou máte základní kurz věnovaný databázím, tj. SQL v zásadě umíte a základní vlastnosti relačních databází znáte.

Budeme používat databázi MariaDB, jejíž SQL je v zásadě stejné, jako příkazy pro Oracle, se kterým už jste pracovali.

**Co po vás budu chtít?**
- příkazy pro CRUD operace, tj. ```SELECT```, ```INSERT```, ```UPDATE```, ```DELETE```
- umět logicky navrhnout strukturu databáze (naklikat ji)
- vědět, jak se chovají cizí klíče
- vědět, co jsou to transakce

**Co po vás naopak chtít nebudu?**
- vytváření a úprava tabulek, views atp.
    - protože strukturu databáze většinou definujeme jen při vývoji aplikace a máme možnost si to naklikat v phpMyAdminu
- definice triggerů a dalších pokročilých funkcionalit (samozřejmě je můžete používat, ale jde to i bez nich)

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

- [SQL turoriál na w3schools.com](https://www.w3schools.com/sql/)
- pár komentovaných příkladů:
    - [create table](./05-ukazky-sql/05-1-create-table.sql)
    - [insert](./05-ukazky-sql/05-2-insert.sql)
    - [select](./05-ukazky-sql/05-3-select.sql)
    - [update](./05-ukazky-sql/05-4-update.sql)
    - [transactions](./05-ukazky-sql/05-5-transactions.sql)
    - [delete](./05-ukazky-sql/05-6-delete.sql)
    - [cascade](./05-ukazky-sql/05-7-cascade.sql)

    
## MySQL a MariaDB
:point_right:

TODO    

### Databáze na serveru eso.vse.cz
:point_right:

TODO    

    
## phpMyAdmin
:point_right:

- phpMyAdmin je komplexní webový nástroj pro práci s MySQL/MariaDB, přičemž je napsaný v PHP a nalezneme ho na většině serverů
- umožňuje nám jednoduše prohlížet a upravovat nejen data, ale i strukturu databáze     

### phpMyAdmin na serveru eso.vse.cz
- phpMyAdmin na serveru eso najdete na adrese **[https://eso.vse.cz/phpmysqladmin](https://eso.vse.cz/phpmysqladmin)**

:orange_book:
- [prezentace s popisem phpMyAdminu](TODO) 



## Jiné přístupy k databázi
:point_right:

K databázi můžete samozřejmě přistupovat nejen pomocí phpMyAdminu, ale také pomocí IDE, konzole a spousty dalších nástrojů. Pro praktické použití uveďme alespoň 2 konkrétní příklady - [Adminer](#adminer) a [připojení z konzole].

### Adminer
:point_right:
- Jde o jednoduché rozhraní pro náhled do dabáze, zejména v situaci, kdy ji nechceme/nemůžeme zpřístupnit pomocí komplexnějšího nástroje.
- Obrovskou výhodou je to, že jde vlastně jen o jeden malý PHP soubor, který můžete nahrát na libovolný hosting s PHP.
- Kromě MariaDB podporuje i celou řadu dalších databází, včetně objektových.
- Nástroj má 2 varianty: *Adminer* a *Adminer Editor* - první z nich zpřístupňuje jen data, druhý umožňuje i naklikat strukturu databáze.  

**Doporučuji vám si tento nástroj vyzkoušet a zapamatovat, protože je to nejjednodušší možný způsob, jak se dostat do databáze, i když není přístupná mimo server.**

:blue_book:
- oficiální web nástroje: [https://www.adminer.org/cs/](https://www.adminer.org/cs/)
- [předinstalovaný Adminer na serveru eso.vse.cz](https://eso.vse.cz/adminer/adminer.php)

### Připojení z konzole
:point_right:

Pokud máte k serveru přístup pomocí ssh, můžete využít také jednoduché připojení pomocí konzole mysql. Tato možnost je k dispozici i na serveru eso.vse.cz, jen pro připojení musíte být na [VPN](https://vpn.vse.cz).

Pokud konzolové nástroje nemáte rádi, určitě vás nenutím, abyste následující postup zkoušeli.

**Jak se připojit k serveru?**
K připojení k serveru buď můžete na použít **ssh** (na novějších verzích win 10 a všech unixových systémech), nebo na windows také nástroj [Putty](https://www.putty.org). 

Připojení k serveru:
```shell script
ssh xname@eso.vse.cz # připojit se na server eso s uživatelským jménem xname (následně se zobrazí výzva pro heslo)
```

Po připojení jste v normálním linuxovém terminálu (konzoli) - na serveru eso.vse.cz jde o bash. Fungují tu tedy všechny běžné příkazy, např ```ls``` pro výpis adresáře, ```cd``` pro jeho změnu atd.
```shell script
cat ~/mysql-heslo.txt # můžete si vypsat heslo k databázi 
```

Až budete chtít připojení ukončit, spusťte příkaz 
```shell script
exit
```

**Jak používat konzolové mysql?**

Připojíme se ke konzoli MySQL/MariaDB:
```shell script
mysql -pHESLO xname # připojení k databázi (název databaze je stejný jako vaše xname). POZOR, mezi -p a heslem není žádná mezera! 
```

Při zadání správného jména a hesla jste přihlášeni do databáze a můžete přímo zadávat SQL příkazy. Například:
```mysql
SHOW TABLES;
SELECT * FORM table;
``` 

Nakonec se nezapomeňte odhlásit pomocí:
```mysql
exit;
``` 

---

## Připojení k databázi z PHP
:point_right:

TODO

## Praktická aplikace využívající databázi
:orange_book:

TODO

## Domácí úkol
:house:

> TODO