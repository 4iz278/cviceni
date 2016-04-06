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

Případy užití:

Část pro uživatele:

* [index](./07-app/index.php) - výpis zboží v e-shopu.
* [buy](./07-app/buy.php) - přidání zboží do košíku dle ID (demonstrace práce se sessions).
* [cart](./07-app/cart.php) - výpis zboží přidaného do košíku (demonstrace práce se sessions).
* [remove](./07-app/remove.php) - smazání zboží z košíku (demonstrace práce se sessions).
* [me](./07-app/me.php) - údaje o uživateli (demonstrace práce s cookies).
* [logout](./07-app/logout.php) - simulace odhlášení, zruší session (demonstrace práce se sessions).

Část pro správce:

* [new](./07-app/new.php) - přidání nového zboží do e-shopu, začne se nabízet ke koupi.
* [delete](./07-app/delete.php) - smazání zboží z e-shopu, přestane se nabízet ke koupi.
* [update](./07-app/update.php) - úprava zboží v e-shopu.


### Poznámky a otázky k aplikaci

* Aplikace zatím nerozlišuje uživatelské role - všichni můžou všechno (registraci, autentizaci a autorizaci budeme dělat příště).
* Přihlášení v horní části lišty není skutečné přihlášení, jen ukazuje práci s cookies (jméno uživatele ukládá do cookie v browseru).
* smazání zboží v admin části - [delete](./07-app/delete.php) a smazání zboží z košíku - [remove](./07-app/remove.php) je lepší udělat přes POST (proč? :)
* **Otázky:**
  * Jak by šlo rozlišit uživatelské role?
  * Jak by vypadal datový model pro role?
  * Jak by bylo možné provést autentizaci a autorizaci v aplikaci?
  * Jaké jsou výhody/nevýhody používání sessions pro košík? Co je/není vhodné do sessions ukládat?
  * Jaké jsou výhody/nevýhody používání cookies obecně? Co je/není vhodné do sessions ukládat?
  * Je třeba mít aplikaci přizpůsobenou pro vypnuté cookies? Proč ano/ne?


## 6. Cookies

* Cookies = sušenky = klíč a hodnota, které se ukládají v browseru.
* Server do browseru pošle cookie. Každý další request z browseru na server tuto cookie vrací v HTTP hlavičce (cookie je součást HTTP hlavičky requestu).
* Cookie je malá databáze na straně serveru.
* Cookie je z bezpečnostních důvodů navázána k URL serveru, který cookie poslal.
* V PHP jsou cookies dostupné v globálním (přístupném odkudkoli) asociativním poli **$_COOKIE** a posílají se (ukládají do browseru) funkcí **setcookie()**.
* Protože je cookie součást HTTP hlavičky, je třeba ji poslat (uložit) ještě před generování jakéhokoli výstupu, podobně jako u HTTP redirectu (hlavička Location).
* **Otázka: Co by se stalo, kdyby neexistovala kontrola na propojení cookie a serveru, který ji poslal a každý server by mohl číst každou cookie?**
* **Otázka: Může uživatel přečíst/přepsat hodnoty v cookies?**
* Podívejte se na cookies uložené v browseru (Firefox - Firebug, Chrome - Developer Tools).
* **Práce s cookies** - viz [me](./07-app/me.php).

## 7. Sessions

* HTTP protokol je stateless (nepamatuje si stav requestu=požadavku konkrétního uživatele, který prochází aplikaci), tzn. že každý HTTP request je považován za nový, unikátní, bez návaznosti na requesty předchozí.
* Sessions přidávání zdání "stateful", aplikace si pak může "pamatovat" uživatele, který ji prochází.
* Session si ze představit jako unikátní ID, ke kterému jsou na serveru uložena nějaká data (v paměti, na disku, záleží na implementaci či nastavení jazyka).
* Sessions se ukládají do cookie nebo se posílají jako parametr v URL.
* V PHP existuje globální (přístupné odkudkoli) asociativní pole **$_SESSION**, do kterého lze ukládat všechny datové typy z PHP (jsou serializovány = převedeny na string, viz příklad [serialize](./07-app/serialize.php).
* Pokud nastartujeme session, uloží se do cookie browseru session id, které se v PHP jmenuje **PHPSESSID** s náhodně generovaným řetězcem, který je těžké odhadnout. Zkontrolujte v browseru (Firefox - Firebug, Chrome - Developer Tools).
* Session nastartujeme (do cookie uložíme/přečteme **PHPSESSID** a zpřístupníme tak data v poli **$\_SESSION**) pomocí funkce **session_start()**.
* Session data zrušíme pomocí funkce **session_destroy()**. Cookie zůstane, ale nemá už přiřazena data na serveru.
* To, že si aplikace bude "pamatovat" uživatele je plně na vývojáři aplikace. PHP pouze uloží/přečte **PHPSESSID** a zpřístupní session data patřící k této náhodné hodnotě.
* **Otázka: Co by se stalo, pokud by hodnota session_id šla jednoduše odhadnout?**
* **Otázka: Jaké jsou obecné vlastnosti pro rozhodování, kdy použít sessions a kdy cookies? Může uživatel přečíst hodnoty v sessions? Může přečíst hodnoty v cookies?**
* **Otázka: Co se stane, pokud ručně přepíšeme/smažeme v cookie hodnotu PHPSESSID? Přidejte zboží do košíku a smažte cookie PHPSESSID.**
* **Práce se sessions** - viz [buy](./07-app/buy.php), [cart](./07-app/cart.php) a [remove](./07-app/remove.php).

## 8. Domácí úkol

Rozšiřte aplikaci - vytvořte tabulku uživatelů a přidejte jednoduchou autentizaci (login/heslo - zatím jen plain text) a autorizaci (jen admin může přidat/upravit/smazat zboží). Košík ukládejte do DB.


