# 8. Uživatelé, autentizace, autorizace

Do našeho e-shopu přidáme autentizaci (KDO je uživatel) a autorizaci (CO může uživatel dělat). Aplikaci může používat pouze přihlášený uživatel. Katalog může spravovat pouze administrátor.

## 1. Zdroje pro cvičení:

* http://php.net/manual/en/function.password-hash.php - hashování hesla
* http://php.net/manual/en/function.password-verify.php - kontrola hesla
* http://php.net/manual/en/features.http-auth.php - HTTP autentizace 

## 2. Vytvoření db schématu

Vytvořte na serveru eso.vse.cz ve vaší MySQL databázi tabulku goods (zboží) a users (uživatelé).

[create table goods and users](./08-schema.sql)

## 3. Naplnění testovacími daty

Naplňte vytvořenou tabulku testovacími daty. Testovací data lze vygenerovat např. aplikací http://www.generatedata.com/

[insert test data](./08-data.sql)

## 4. Připojení k databázi

Pro práci s DB budeme opět používat třídu [PDO](http://php.net/manual/en/class.pdo.php), která je abstraktním objektem nad jakoukoli databází:

[db.php](./08-app/db.php)

**Nezapomeňte v souboru nastavit váš xname a heslo pro připojení do db!**

## 5. Práce s aplikací

Zkopírujte scripty z adresáře 08-data do vašeho adresáře na serveru eso.vse.cz.

Funkční aplikaci pak najdete na adrese:

https://eso.vse.cz/~xhraj18/ (použijte váš vlastní xname :)

Případy užití:

Část pro nepřihlášeného uživatele/databázová autentizace:

* [signup](./08-app/signup.php) - registrace nového uživatele (demonstrace práce s hashováním hesla).
* [signin](./08-app/signup.php) - registrace nového uživatele (demonstrace práce s hashováním hesla).

Část pro přihlášeného uživatele:

* [index](./08-app/index.php) - výpis zboží v e-shopu.
* [buy](./08-app/buy.php) - přidání zboží do košíku dle ID (demonstrace práce se sessions).
* [cart](./08-app/cart.php) - výpis zboží přidaného do košíku (demonstrace práce se sessions).
* [remove](./08-app/remove.php) - smazání zboží z košíku (demonstrace práce se sessions).
* [signout](./08-app/signout.php) - odhlášení, zruší session (demonstrace práce se sessions).

Část pro administátora (správce):

* [new](./08-app/new.php) - přidání nového zboží do e-shopu, začne se nabízet ke koupi.
* [delete](./08-app/delete.php) - smazání zboží z e-shopu, přestane se nabízet ke koupi.
* [update](./08-app/update.php) - úprava zboží v e-shopu.

Část pro autorizaci a HTTP autentizaci:

* [user required](./08-app/user_required.php) - soubor pro require, vynucení přihlášení uživatele.
* [admin required](./08-app/admin_required.php) - soubor pro require, vynucení přihlášení administrátora, demonstrace HTTP autentizace.


### Poznámky a otázky k aplikaci

* 
* 
* **Otázky:**
  * 
  * 


## 6. Hashování hesla

* 

## 7. Autentizace

* 

## 8. Autorizace

* 


## 9. Domácí úkol

Dle zadání cvičícího, autentizace/autorizace ve vlastní aplikaci (nejlépe pro vaši rozpracovanou semestrální práci).





