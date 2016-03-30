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

**Nezapomeňte v souboru nastavit váš xname a heslo pro připojení do db!**

Další možností je používat [mysqli](http://php.net/manual/en/book.mysqli.php).

## 5. Práce s aplikací

Zkopírujte scripty z adresáře 06-data do vašeho adresáře na serveru eso.vse.cz.

Funkční aplikaci pak najdete na adrese:

https://eso.vse.cz/~xhraj18/ (použijte váš vlastní xname :)

CRUD případy užití:

* [create](./06-app/new_prepare.php) - vytvoření nového klienta
* [read - index](./06-app/index.php) - výpis klientů
* [read - index with pagination](./06-app/index_with_pagination.php) - výpis klientů se stránkováním
* [update](./06-app/update.php) - úprava klienta
* [delete](./06-app/delete.php) - smazání klienta

### Poznámky a otázky k aplikaci

* Pro mazání bychom měli používat HTTP POST (proč?). V příkladu je použit HTTP GET. Co třeba web roboti?
* Po přidání/úpravě/mazání záznamu je třeba udělat HTTP redirect pomocí hlavičky Location. Proč?
* Create/update děláme pomocí PDO parametrů. Lze je mít i pojmenované  - named parameters, viz kód v [create](./06-app/new_prepare.php).
* Před delete je vhodné potvrzení ze strany uživatele, že chce záznam skutečně smazat. Jak to jde udělat?
* Záznamy v tabulce je vhodné stránkovat, viz [index with pagination](./06-app/index_with_pagination.php). Jaké to má výhody/nevýhody? (tiskové sestavy, hledání fulltextem na stránce pomocí CTRL+F...)

## 6. SQL inject útok

Vstupy posílané do DB je třeba ošetřit, jinak hrozí SQL inject útok.

Porovnejte a zkuste tyto příklady pro přidání nového klienta do databáze:

* [open to attacks](./06-app/new_open.php) - neošetřené vstupy, **zkuste si SQL inject útok**.
* [mysql_real_escape_string](./06-app/new_escape.php) - ruční ošetření vstupů přes funkci [mysql_real_escape_string](http://php.net/mysql_real_escape_string). Srovnejte ještě s deprecated funkcí [mysql_escape_string](http://php.net/mysql_escape_string). **Obě funkce jsou deprecated, používat PDO nebo mysqli!**
* [PDO parameters](./06-app/new_prepare.php) - vstupy přes PDO parametry, automaticky chráněno proti SQL inject útokům.

[Detailní ukázka SQL inject útoku včetně zobrazení, co se přesně posílá do databáze.](./06-app/mysql_real_escape_string.php)

![Exploits of a mom](./exploits-of-a-mom.png)




