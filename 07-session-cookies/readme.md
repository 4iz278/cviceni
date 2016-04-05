# 7. Session, cookies

Pro ukázku vytvoříme aplikaci e-shopu (CRUD), používající sessions pro nákupní košík a cookies pro přihlášeného uživatele.

## 1. Zdroje pro cvičení:

* http://php.net/manual/en/book.session.php - funkce pro práci se sessions.
* http://php.net/manual/en/features.cookies.php - práce s cookies.

## 2. Vytvoření db schématu

Vytvořte na serveru eso.vse.cz ve vaší MySQL databázi tabulku goods (zboží):

[create table goods](./07-schema.sql)

## 3. Naplnění testovacími daty

Naplňte vytvořenou tabulku testovacími daty. Testovací data lze vygenerovat např. aplikací http://www.generatedata.com/

[insert test data](./07-data.sql)

## 4. Připojení k databázi

Pro práci s DB budeme opět používat třídu [PDO](http://php.net/manual/en/class.pdo.php), která je abstraktním objektem nad jakoukoli databází:

[db.php](./07-app/db.php)

**Nezapomeňte v souboru nastavit váš xname a heslo pro připojení do db!**

## 5. Práce s aplikací

Zkopírujte scripty z adresáře 07-data do vašeho adresáře na serveru eso.vse.cz.

Funkční aplikaci pak najdete na adrese:

https://eso.vse.cz/~xhraj18/ (použijte váš vlastní xname :)

CRUD případy užití:

* [index](./07-app/index.php) - výpis zboží v e-shopu
* [buy](./07-app/buy.php) - přidání zboží do košíku dle ID
* [cart](./07-app/cart.php) - výpis zboží přidaného do košíku
* [remove](./07-app/remove.php) - smazání zboží z košíku


## 6. Cookies

* 

## 7. Sessions

* HTTP protokol je stateless (nepamatuje si konkrétního uživatele, který prochází aplikaci), tzn. že každý HTTP request je považován za nový, unikátní, bez návaznosti na requesty předchozí
* Sessions přidávání zdání "stateful", aplikace si pak může "pamatovat" uživatele, který ji prochází
* Session si ze představit jako unikátní ID, pomocí kterého server pozná, že aplikaci používá ten samý uživatel
* Sessions se ukládají do cookie nebo se posílají jako parametr v URL
* V PHP existuje globální (přístupné odkudkoli z PHP) pole **$_SESSION**, do kterého lze ukládat všechny datové typy z PHP (jsou serializovány = převedeny na string)


### Poznámky a otázky k aplikaci

* 


