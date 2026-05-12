# 13. Datum a čas, víceuživatelský přístup k DB

## Práce s datem a časem
:point_right:

S datem a časem se setkáváme ve větším množství případů, než by se mohlo na první pohled zdát. V každém redakčním systému máme zobrazenou informaci o poslední změně článku, e-maily a objednávky mají své datum odeslání, ale např. také ban, který dostaneme na diskusním fóru, má své datum vypršení. Je tedy nezbytné, abychom se seznámili s tím, jak s datem a časem pracovat z PHP.

:point_right:

- pro práci s datem a časem máme v PHP na výběr 2 varianty:
    1. funkce, se kterými můžeme pracovat s konkrétními hodnotami časových údajů (např. funkce ```date()```)
    2. objektový přístup, ve kterém jsou časové údaje instancemi tříd (např. ```DateTime```, ```DateInterval``` atd.)
- existuje celá řada způsobů formátování data a času do čitelné podoby
    - pro zobrazení uživatelům bychom měli volit takový formát, který pro něj přirozený (např. u nás je příjemnější si přečíst datum *22.4.2020*, než *2020-04-22*)
    - pro specifické případy (např. cookies, rss atp.) existují předdefinované tvary zápisu data, ale jinak si můžeme datum naformátovat dle svého uvážení
- nezapomeňte, že s datem a časem jde pracovat i přímo v SQL dotazech
    - pokud např. chceme vybrat z databáze články, které se změnily v posledním týdnu, napíšeme daný posun času přímo do SQL - rozhodně tedy nenačítáme všechny články do PHP, abychom je teprve poté filtrovali
    - do databáze ukládáme datum a čas ve standardním formátu (např. DATETIME: `Y-m-d H:i:s`), formátování (např. `d.m.Y`) řešíme až při výpisu uživateli
    
:point_right:

**Základní funkce pro práci s datem a časem**         

Pro základní práci s datem a časem si ve většině případů vystačíme dokonce jen se třemi funkcemi. Pojďme se na ně podívat:

```php
//funkce time() nám vrací aktuální timestamp (počet sekund od 1.1.1970)
$timestamp = time(); 

//timestamp je číslo, můžeme tedy s ním tak pracovat - v tomto případě přičteme 5 minut
//pozor na to, že přímé přičítání sekund (např. +86400) nemusí vždy odpovídat jednomu kalendářnímu dni (kvůli změně na letní/zimní čas)
$timestampPred5Minutami = $timestamp - 5*60;

//funkce pro převod řetězce obsahujícího datum a čas na timestamp (tuto funkci používáme např. pro převod datumu získaného z SQL dotazu)
//reálně lze tuto funkci použít i pro posun času atp. - např. strtotime('+1 day')
$timestamp = strtotime('2026-04-22 10:00:00');

//funkce pro naformátování data do požadovaného tvaru
echo date('d.m.Y H:i:s', $timestamp);
```

:point_right:

**Objektový přístup k datu a času**

- Objekty představující časové údaje používáme zejména v případě, kdy chceme používat kontrolu datových typů u funkcí/metod, nebo používáme objektově-relační mapování při ukládání dat do databáze.
  - vyjma jednoduchých konverzí a výpisů jde dnes o běžnější způsob práce s datem a časem
- vedle třídy DateTime existuje také DateTimeImmutable (neměnitelná varianta)

```php
//vytvoření objektu DateTime s hodnotou aktuálního data a času
$date = new DateTime();

//výpis naformátovaného data
echo $date->format('d.m.Y');

//vytvoření DateTime z naformátovaného řetězce
$date = DateTime::createFromFormat('Y-m-d', '2026-04-22');

//neměnný objekt DateTimeImmutable - často používaný v kombinaci s objektově-relačním mapováním atp.
$date2 = DateTimeImmutable::createFromFormat('Y-m-d', '2026-04-22');

//v případě DateTimeImmutable při změně získáme zcela nový objekt
$date3 = $date2->add(new DateInterval('P1D')); // P1D = 1 day (ISO 8601 formát)
```

:grey_exclamation:

**Pozor na časové pásmo (timezone)!**
- PHP používá výchozí timezone nastavenou na serveru
- doporučuje se ji explicitně nastavit, např.:
```php
date_default_timezone_set('Europe/Prague');
```

:point_right:

Funkcí i tříd pracujících pro práci s datem a časem existuje poměrně velké množství, podrobněji si je představíme v následujících 2 ukázkových příkladech. 

:blue_book:
- [příklad použití funkcí pro práci s datem a časem](./09-datetime-functions.php)
- [příklad použití objektů pro práci s datem a časem](./09-datetime-objects.php)
- [funkce date() v PHP manuálu](https://www.php.net/manual/en/function.date.php)
- [Class DateTime v PHP manuálu](https://www.php.net/manual/en/class.datetime.php)
- [PHP Date/Time Functions na w3schols.com](https://www.w3schools.com/php/php_ref_date.asp)

## Víceuživatelský přístup k databázi
:point_right:

- Webové aplikace jsou samozřejmě určeny pro větší množství uživatelů, kteří je mohou používat ve stejný čas. Otázka, kterou si ale musíme při tvorbě aplikace položit, je ta, zda mohou uživatelé upravovat stejná data (např. administrátoři e-shopu mohou spravovat zboží, objednávky atp.), či nikoliv (např. každý uživatel může upravovat svůj profil).
- V případě, že existuje riziko, že bude chtít najednou upravovat více uživatelů jedna a ta samá data, měli bychom v aplikaci implementovat **zamykání záznamů**.
- Situace, kdy více uživatelů pracuje se stejnými daty a může dojít k jejich přepsání, označujeme jako **race condition**.
- Často používaným řešením je tzv. **zamykání záznamů.**

### Typy zámků 
:point_right:

V aplikaci můžeme využít buď optimistické, nebo pesimistické zamykání záznamů. Vybereme si z nich podle toho, zda očekáváme, že každý uživatel, který si data otevře k úpravě, nějakou úpravu opravdu provede.
Pojďme si je tedy blíže představit.

:point_right:

#### Optimistic lock = optimistické zamykání
Více uživatelů může najednou začít upravovat stejný záznam, ale očekáváme, že jej většina z nich neuloží (např. záznam ve sdíleném adresáři).

**Postup:**
1. při otevření záznamu pro úpravu si zapamatujeme datum a čas jeho poslední změny
2. v okamžiku uložení změněného záznamu zkontrolujeme, jestli se náš uložený datum a čas poslední změny shodují s datem a časem, kdy byl záznam opravdu naposledy upraven
    - pokud v mezičase došlo ke změně, data neuložíme, ale upozorníme uživatele na tuto změnu

Alternativně lze použít kromě data a času také informaci o verzi záznamu uloženou v databázi (např. ve sloupci `version`).

:point_right:

#### Pessimistic lock = pesimistické zamykání
Očekáváme, že téměř každý uživatel, který si otevře záznam k úpravě, jej opravdu upraví. (např. stránku v CMS) V okamžiku otevření záznamu k úpravě jej tedy pro ostatní uživatele uzamkneme a nedovolíme jim jej začít upravovat. Ostatní uživatelé musí počkat, než dokončíme editaci.

**Postup:**     
1. při otevření záznamu pro úpravu si k němu do databáze uložíme ID uživatele, který začal záznam upravovat, a také aktuální datum a čas (pro časové omezení platnosti zámku)
2. pokud se záznam pokusí otevřít pro úpravu jiný uživatel, ověříme, jestli je stále platný u něj uložený zámek
    - pokud ano, neumožníme uživateli záznam pro úpravu otevřít
    - pozor na to, že uživatel může jen ze stránky odejít bez uložení či zavření záznamu (proto řešíme zmíněnou platnost/expiraci zámku) 
3. při ukládání záznamu zkontrolujeme, zda není záznam uzamčen pro jiného uživatele (např. po časovém vypršení našeho vlastního zámku)
4. při uložení záznamu či potvrzení zrušení jeho úpravy smažeme u daného záznamu informace o uživateli a čas zamčení daného záznamu

### Ukázková aplikace se zamykáním záznamů
:point_right:

Pro ukázku použití zamykání záznamů při víceuživatelském přístupu se podívejme na další verzi aplikace jednoduchého e-shopu, která v tomto případě jak optimistickým, tak také pesimistickým zámkem při editaci zboží.
- stejně jako ve verzi z minulého cvičení využívá aplikace autentizaci uživatelů dle údajů v databázi, informace o přihlášení je uložena v session
- oproti minulému cvičení je i administrátor ověřován podle údajů v databázi
    - pro testování je v aplikaci připraven uživatel s e-mailem ```admin@eshop.tld``` a heslem ```admin```, ale příslušnou roli můžete v databázi přidat i libovolnému jinému uživateli 
- aplikace nemá ošetřené vstupy (prázdné heslo atp), pouze zamezuje SQL inject útoku - DIY :)   

Zkuste si tuto aplikaci spustit a projděte si okomentované zdrojové kódy.

:blue_book:
- postup zprovoznění ukázkové aplikace:
    1. stáhněte si celou složku aplikace ([13-app-eshop](./13-app-eshop)) a nahrajte ji na server
    2. nahrajte do MariaDB [strukturu databáze](./13-app-eshop/db-schema.sql) (pozor, schéma není stejné jako u předchozí verze e-shopu)
    3. nahrajte do MariaDB [ukázková data](./13-app-eshop/db-data.sql)
    4. nastavte vlastní xname a heslo k databázi v souboru [db.php](./13-app-eshop/inc/db.php)
- většina aplikace je podobná té z [podkladů k uživatelským účtům](../10-uzivatele#uk%C3%A1zkov%C3%A1-aplikace-s-u%C5%BEivatelsk%C3%BDmi-%C3%BA%C4%8Dty), ale má upravené schéma databáze a editaci záznamů
  - část pro nepřihlášeného uživatele/databázová autentizace:
      - [signup.php](./13-app-eshop/signup.php) - registrace nového uživatele, ukázka práce s funkcí password_hash
      - [signin.php](./13-app-eshop/signin.php) - přihlášení existujícího uživatele, ukázka práce s funkcí password_verify
  - část pro přihlášeného uživatele:
    - [index.php](./13-app-eshop/index.php) - výpis zboží v e-shopu
    - [buy.php](./13-app-eshop/buy.php) - přidání zboží do košíku podle jeho ID
    - [cart.php](./13-app-eshop/cart.php) - výpis zboží přidaného do košíku
    - [remove.php](./13-app-eshop/remove.php) - smazání zboží z košíku
    - [signout.php](./13-app-eshop/signout.php) - odhlášení, zruší session
  - část pro administátora:
    - [new.php](./13-app-eshop/new.php) - přidání nového zboží do e-shopu, začne se nabízet ke koupi
    - [delete.php](./13-app-eshop/delete.php) - smazání zboží z e-shopu, přestane se nabízet ke koupi
- upravená část pro ověřování práv uživatelů:
    - [user required.php](./13-app-eshop/inc/user_required.php) - soubor pro require, vynucení přihlášení uživatele, autentizace uložená v SESSION
    - [admin required.php](./13-app-eshop/inc/admin_required.php) - soubor pro require, **ověřuje, zda je přihlášený uživatel v roli "admin" uloženou v databázi** (jde vlastně o rozšíření souboru user_required.pph)    
- upravená část pro administátora:
    - [update_optimistic.php](./13-app-eshop/update_optimistic.php) - **úprava zboží v e-shopu s optimistickým zamykáním záznamů**
    - [update_pessimistic.php](./13-app-eshop/update_pessimistic.php) - **úprava zboží v e-shopu s pesimistickým zamykáním záznamů** 

:point_right:
*Otázky k zamyšlení:*
- *Musíme zamykání záznamů použít vždy? Kdy ano a kdy ne?*
- *Ukázka optimistického zamykání [update optimistic](./09-app-eshop/update_optimistic.php) používá předání data a času poslední editace přes formulářové hidden pole. Tato data však mohou být při odeslání formuláře změněna/podstrčena uživatelem. Jak se jde proti tomu bránit?*
