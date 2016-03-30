# 6. Práce s databází v PHP

Jako ukázku práce s databází vytvoříme jednoduchou aplikaci, demonstrující základní práci nad daty - Create, Read, Update, Delete (zkráceně CRUD aplikace).

## 1. Zdroje pro cvičení:

* http://php.net/manual/en/class.pdo.php - třída PDO pro abstraktní práci nad databází.
* http://php.net/manual/en/book.mysqli.php - MySQL Improved Extension - funkce pro práci s mysql. Lze používat PDO NEBO mysqli, ale nemíchat obojí!
* http://php.net/manual/en/ref.mysql.php - klasické a staré mysql funkce, nepoužívat, musíme ošetřovat vstupy, je to složité, preferovat PDO nebo mysqli.
* http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers - rozdíly mezi mysql funkcemi a PDO.
* http://wiki.hashphp.org/Validation - ukázka SQL injectu a validace vstupů do DB.
* http://www.generatedata.com - generátor testovacích dat pro různé databáze.

## 2. Vytvoření db schématu

Vytvořte na serveru eso.vse.cz ve vaší MySQL databázi tabulku clients:

[create table clients](./06-schema.sql)

## 3. Naplnění testovacími daty

Naplňte vytvořenou tabulku testovacími daty. Testovací data lze vygenerovat např. aplikací http://www.generatedata.com/

[insert test data](./06-data.sql)

## 4. Připojení k databázi

Pro práci s DB budeme používat třídu [PDO](http://php.net/manual/en/class.pdo.php), která je abstraktním objektem nad jakoukoli databází:

[db.php](./06-app/db.php)

Další možností je používat [mysqli](http://php.net/manual/en/book.mysqli.php).

## 5. Práce s aplikací

Zkopírujte scripty z adresáře 06-data do vašeho adresáře na serveru eso.vse.cz.

Funkční aplikaci pak najdete na adrese:

https://eso.vse.cz/~xhraj18/ (použijte váš vlastní xname :)

CRUD případy užití:

* [create](./06-app/new_prepare.php) - vytvoření nového klienta
* [read](./06-app/index.php) - výpis klientů
* [update](./06-app/update.php) - úprava klienta
* [delete](./06-app/delete.php) - smazání klienta

### Poznámky k aplikaci

* Pro mazání bychom měli používat HTTP POST (proč?). V příkladu je použit HTTP GET. Co třeba web roboti?
* Po přidání/úpravě/mazání záznamu je třeba udělat HTTP redirect pomocí hlavičky Location. Proč?
* Create/update děláme pomocí PDO parametrů. Lze je mít i pojmenované  - named parameters, viz kód v [create](./06-app/new_prepare.php).

## 6. SQL inject útok

Vstupy posílané do DB je třeba ošetřit, jinak hrozí SQL inject útok.

Porovnejte a zkuste tyto příklady:

* [open to attacks](./06-app/new_open.php) - neošetřené vstupy, zkuste si SQL inject útok.
* [mysql_real_escape_string](./06-app/new_escape.php) - ruční ošetření vstupů přes funkci [mysql_real_escape_string](http://php.net/mysql_real_escape_string). Pozn. Srovnejte ještě s deprecated funkcí [mysql_escape_string](http://php.net/mysql_escape_string).
* [PDO parameters](./06-app/new_prepare.php) - vstupy přes PDO parametry, automaticky chráněno proti SQL inject útokům.

![Exploits of a mom](./exploits-of-a-mom.png)




