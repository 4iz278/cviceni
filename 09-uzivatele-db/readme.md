# 9. Uživatelé a DB, víceuživatelský přístup, práce s datem/časem, OAuth

Do našeho e-shopu přidáme zamykání záznamů pro případ, kdyby jeden záznam potřebovalo upravovat více uživatelů najednou.
Dále se naučíme pracovat s funkcemi pro datum a čas a naučíme se přihlásit se do aplikace pomocí Facebooku (OAuth protokol).

## 1. Zdroje pro cvičení:

* https://docs.jboss.org/jbossas/docs/Server_Configuration_Guide/4/html/TransactionJTA_Overview-Pessimistic_and_optimistic_locking.html - optimistické vs pesimistické zamykání (optimistic vs pessimistic lock)
* http://dev.mysql.com/doc/refman/5.5/en/timestamp-initialization.html - inicializace datového typu timestamp v MySQL.
* http://php.net/manual/en/intro.datetime.php - úvod do práce s datem/časem v PHP.
* http://php.net/manual/en/ref.datetime.php - funkce pro práci s datem/časem v PHP.
* http://php.net/manual/en/class.dateinterval.php - práce s intervaly data/času v PHP.
* http://php.net/manual/en/timezones.php - podporované časové zóny v PHP (naše je **Europe/Prague**).

## 2. Vytvoření db schématu

Vytvořte na serveru eso.vse.cz ve vaší MySQL databázi tabulku goods (zboží) a users (uživatelé). Oproti minulým příkladům má tabulka goods 3 nové sloupce pro optimické/pesimistické zamykání: last_updated_at, last_edit_starts_at a last_edit_starts_by_id.

[create table goods and users](./09-schema.sql)

## 3. Naplnění testovacími daty

Naplňte vytvořenou tabulku testovacími daty. Testovací data lze vygenerovat např. aplikací http://www.generatedata.com/

[insert test data](./09-data.sql)

## 4. Připojení k databázi

Pro práci s DB budeme opět používat třídu [PDO](http://php.net/manual/en/class.pdo.php), která je abstraktním objektem nad jakoukoli databází:

[db.php](./09-app/db.php)

**Nezapomeňte v souboru nastavit váš xname a heslo pro připojení do db!**

## 5. Práce s aplikací

Zkopírujte scripty z adresáře 09-data do vašeho adresáře na serveru eso.vse.cz.

Funkční aplikaci pak najdete na adrese:

https://eso.vse.cz/~xhraj18/ (použijte váš vlastní xname :)

Případy užití:

*Poznámka: pro jednoduchost jsme zrušili přístup pro admina, vyžadujeme jen přihlášeného uživatele.*

Část pro nepřihlášeného uživatele/databázová autentizace:

* [signup](./09-app/signup.php) - registrace nového uživatele.
* [signin](./09-app/signin.php) - přihlášení existujícího uživatele.

Část pro přihlášeného uživatele:

* [new](./09-app/new.php) - přidání nového zboží do e-shopu.
* [delete](./09-app/delete.php) - smazání zboží z e-shopu.
* [index](./09-app/index.php) - výpis zboží v e-shopu.
* [buy](./09-app/buy.php) - přidání zboží do košíku.
* [cart](./09-app/cart.php) - výpis zboží přidaného do košíku.
* [remove](./09-app/remove.php) - smazání zboží z košíku.
* [signout](./09-app/signout.php) - odhlášení uživatele.

Části pro přihlášeného uživatele relevantní pro toto cvičení:

* [update](./09-app/update.php) - optimistic lock
* [update with locking](./09-app/update_with_locking.php) - pessimistic lock



### Poznámky a otázky k aplikaci

* **Otázky:**
  * 



##  Domácí úkol

1. 

TODO


