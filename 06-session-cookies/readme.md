# 6. Opakování práce s databází, session, cookies

:grey_exclamation: **Tato složka obsahuje podklady k domácímu studiu ke cvičením 2. a 3. 4. 2020.**
Oproti běžným podkladům ke cvičením zde naleznete podrobnější vysvětlení dané problematiky a další příklady.

## Opakování z minulého cvičení

:point_right:

V rámci [minulého cvičení](../05-sql-databaze) jsme se zabývali vlastnostmi databáze MariaDB. Následně jsme si:
- [ukázali práci s nástrojem phpMyAdmin](../05-sql-databaze/05-prezentace-phpmyadmin.pptx),
- probrali používání databáze pomocí PDO  
- a [ukázali tvorbu databázové aplikace v rámci komentované prezentace](../05-sql-databaze#tvorba-aplikace-vyu%C5%BE%C3%ADvaj%C3%ADc%C3%AD-datab%C3%A1zi).

Místo podrobného opakování se rovnou vrhneme na obsah dnešního cvičení, protože se na práci s databází podíváme ještě v dalším komentovaném ukázkovém příkladu. 

    
:house:

Ještě připomínám, že součástí byl také [domácí úkol](../05-sql-databaze#dom%C3%A1c%C3%AD-%C3%BAkol). Pokud jej máte (byť i jen z části) hotový, nezapomeňte na jeho odevzdání.
    
---

:point_right:

**Na tomto cvičení nás čeká:**
- [opakování práce s databází](#opakov%C3%A1n%C3%AD-pr%C3%A1ce-s-datab%C3%A1z%C3%AD) prostřednictvím další ukázkové aplikace  
- [cookies](#cookies)
- [session](#session)
- [vyzkoušení si práce se session](#jednoduch%C3%A9-vyzkou%C5%A1en%C3%AD-pr%C3%A1ce-se-session) 
- [ukázková aplikace](#uk%C3%A1zkov%C3%A1-aplikace) a na ní navazující [domácí úkol](#dom%C3%A1c%C3%AD-%C3%BAkol)
---      

## Opakování práce s databází
:point_right:

S ohledem na to, že s databází budeme pracovat až do konce semestru, ještě bychom si měli práci s ní procvičit.
**Projděte si prosím následující okomentované zdrojové kódy.**

:blue_book:
- postup zprovoznění ukázkové aplikace:
    1. stáhněte si celou složku aplikace ([06-db-app-clients](./06-db-app-clients)) a nahrajte ji na server
    2. nahrajte do MariaDB [strukturu databáze](./06-db-app-clients/06-schema.sql)
    3. nahrajte do MariaDB [ukázková data](./06-db-app-clients/06-data.sql)
    4. nastavte vlastní xname a heslo k databázi v souboru [db.php](./06-db-app-clients/db.php)
- ukázkové skripty v aplikaci:
    - [jednoduchý výpis klientů](./06-db-app-clients/index.php)
    - [výpis klientů se stránkováním](./06-db-app-clients/index_with_pagination.php)
    - [vytvoření nového klienta](./06-db-app-clients/new_prepare.php)
    - [vytvoření nového klienta - bez ošetření SQL injection](./06-db-app-clients/new_open.php)
    - [úprava klienta](./06-db-app-clients/update.php)
    - [smazání klienta](./06-db-app-clients/delete.php)    

## Cookies

:point_right:

Ačkoliv jsme dosud pracovali s PHP zcela bezstavově, při reálném nasazení velmi často narážíme na potřebu ukládání informací o tom, co dělal uživatel v předchozích požadavcích. Například u e-shopu považujeme za normální, že postupně vybíráme zboží, přidáváme ho do košíku a teprve poté odešleme objednávku. A rozhodně to nezvládneme na jedné jediné stránce.

Nejjednodušší variantou, jak si předávat data mezi skripty, je jejich posílání - buď si je vždy necháme poslat (např. v parametrech URL adresy), nebo si je uložíme v prohlížeči v podobě **cookies**.

:point_right:

**Cookies nejsou jen "sušenky", ale také jednoduchý způsob uložení informací v prohlížeči ve tvaru klíč = hodnota.**
- Server (PHP) odešle požadavek na uložení cookie. Prohlížeč si tyto informace zapamatuje a posílá danou cookie na server při každém dalším požadavku na danou doménu.
    - Když si uložíme cookie požadavkem ze souboru index.php, tak se pošle na server při všech požadavcích na další skripty, obrázky atp. (tj. přenáší se opravdu v každém požadavku). **Do cookies ukládáme jen opravdu malé objemy informací.**
- Cookies mohou být dostupné jak z javascriptu, tak také ze serveru. Zrovna tak je ale uživatel může v prohlížeči kompletně zakázat.
- Cookies mohou mít omezenou platnost (po jejím vypršení je prohlížeč smaže).
- Pozor: Uživatel si může cookies v prohlížeči nejen zobrazit, ale také je přepsat!
- Pokud používáme cookies pro trasování uživatele (sledování jeho chování na webu), měli bychom mít jeho souhlas.    
    
:point_right:

Pro nastavení cookies používáme funkci ```setcookie()```, která nám sestaví a odešle příslušnou HTTP hlavičku s nastavením. Stejně jako např. funkci ```header()``` musíme i nastavení cookies volat před začátkem odesílání HTML obsahu (jako třeba u přesměrování po odeslání formuláře).
    
```php
setcookie('cookie1', 'hodnota', time() + 3600); //ukládáme cookie s platností 1 hodinu
setcookie('cookie2', 'hodnota', time() + 3600*24, "/xname/"); //ukládáme cookie s platností 1 den, která bude dostupná jen pro adresář /xname/
```

Pro čtení máme cookies dostupné kdekoliv ve skriptu v globální proměnné ```$_COOKIE```. Pozor, přepsáním hodnoty v tomto poli se žádná cookie neuloží!

```php
echo $_COOKIE['cookie1']; //výpis cookie
```

:blue_book:
- [Funkce setcookie() na w3schools.com](https://www.w3schools.com/php/func_network_setcookie.asp)

## Session

:point_right:

Jak už bylo zmíněno, při činnosti aplikace velmi často potřebujeme vědět, jaké požadavky odeslal uživatel před tím současným (například zda se přihlásil, co přidal do košíku atp.). Tyto informace potřebujeme na straně serveru a také potřebujeme, aby je uživatel nemohl jednoduše podvrhnout (například nám tvrdit, že je přihlášený, ačkoliv není). 
A právě k tomu se velmi hodí SESSION - což je vlastně datové pole, které si můžeme uchovávat na serveru a je dostupné všem následně volaným PHP skriptům.

- V reálu jde o místo (na disku, v paměti atp.), které je označeno unikátním ID uživatele a do kterého můžeme si do něj ukládat informace, které chceme mít dostupné i na další stránce.
- Samotné ID pro identifikaci session se ukládá do cookie, nebo se případně přidává jako parametr do URL.
- To, že si aplikace pamatuje například přihlášeného uživatele, je věcí vývojáře. Server jen zpřístupní pole s daty podle ID, které obdržel v rámci požadavku uživatele.

:point_right:

Kdykoliv chceme v PHP session použít, musíme ji nejprve **nastartovat pomocí funkce** ```session_start()```, kterou zavoláme před začátkem odesílání obsahu. 
- Pokud pro daného uživatele ještě session nemáme, odešle se do prohlížeče požadavek na uložení cookie *PHPSESSID* s náhodně generovaným řetězcem, který je těžké odhadnout. Zároveň se nám zpřístupní globální pole ```$_SESSION``` pro ukládání informací na serveru.
- Pokud uživatel již ve svém požadavku odeslat na server *PHPSESSID*, načtou se do pole ```$_SESSION``` hodnoty, které v něm byl při předchozím požadavku.       

:point_right:

**Data v session** máme v PHP přístupná v globálním poli ```$_SESSION```.
- Jde o normální asociační pole, do kterého můžeme informace ukládat kdekoliv v rámci skriptu.
- Pokud do session chceme ukládat objekty, musí být serializovatelné (viz [4. cvičení](../04-objekty-II-validace#serializace-a-usp%C3%A1v%C3%A1n%C3%AD-objekt%C5%AF)) 

```php
session_start(); //nastartování session

$_SESSION['uzivatel']='jmeno'; // zápis hodnoty do session
echo $_SESSION['pocet_pristupu'];// načtení hodnoty ze session
unset($_SESSION['x']); //smazání hodnoty ze session
```

:point_right:

Pokud budeme chtít session ukončit, zavoláme funkci ```session_destroy()```.
- Dojde ke smazání dat o session na straně serveru (cookie v prohlížeči zůstane, ale k danému *PHPSESSID* již nejsou přiřazena žádná data).

Pokud jen budeme chtít změnit hodnotu *PHPSESSID*, zavoláme funkci ```session_regenerate_id()```.

### Jednoduché vyzkoušení práce se session

:point_right:

Abychom si SESSION nepopisovali jen teoreticky, podívejte se na následující 2 praktické příklady s okomentovaným postupem tvorby.

:orange_book:

Nejpve si vytvoříme jednoduché počítadlo přístupů. Při každém načtení stránky se zvětší hodnota uložená v session.
- [prezentace s postupem řešení](./06-pocitadlo-pristupu/prezentace-pocitadlo.pptx)
- [zdrojový kód](./06-pocitadlo-pristupu/pocitadlo.php)


:orange_book:

Druhým jednoduchým příkladem je uložení informace z formuláře. Konkrétně půjde o jednoduchý přihlašovací formulář, zatím ale bez ověření uživatele vůči dabázi (o tom až [příště](../07-uzivatele)).
- [prezentace s postupem řešení](./06-priklad-prihlaseni/prezentace-priklad-prihlaseni.pptx)
- [zdrojový kód](./06-priklad-prihlaseni)

### Další informace k session
:point_right:

Pár otázek k zamyšlení (a případně vyzkoušení v praxi):
- *Co by se stalo, pokud by hodnota PHPSESSID šla jednoduše odhadnout?*
- *Co se stane, pokud ručně přepíšeme/smažeme v cookie hodnotu PHPSESSID?*
- *Jsou nějaká data, která je vhodnější uložit do COOKIE, než do SESSION?*
- *Co se stane, když si na jednom počítači otevřu stejnou stránku ve dvou různých prohlížečích? Bude session sdílená?*


:blue_book:

Pokud byste hledali další informace, koukněte na:
- [Sessions na webu w3schools.com](https://www.w3schools.com/php/php_sessions.asp)
- [Sessions v PHP manuálu](https://www.php.net/manual/en/book.session.php)

## Ukázková aplikace 
:point_right:

Pro lepší představu o práci se session a cookies tu máme připravenou již hotovou aplikaci, představující jednoduchý e-shop.
- Aplikace využívá session pro nákupní košík a cookies pro uložení jména uživatele.
- Přihlášení v horní části lišty není skutečné přihlášení, jen ukazuje práci s cookies (jméno uživatele ukládá do cookie v browseru).
- Aplikace zatím nijak neřeší oprávnění uživatelů (všichni mohou vše).  

Zkuste si tuto aplikaci spustit a projděte si okomentované zdrojové kódy.

:blue_book:
- postup zprovoznění ukázkové aplikace:
    1. stáhněte si celou složku aplikace ([06-app-eshop](./06-app-eshop)) a nahrajte ji na server
    2. nahrajte do MariaDB [strukturu databáze](./06-app-eshop/06-schema.sql)
    3. nahrajte do MariaDB [ukázková data](./06-app-eshop/06-data.sql)
    4. nastavte vlastní xname a heslo k databázi v souboru [db.php](./06-app-eshop/db.php)
- část aplikace pro uživatele:
    - [index.php](./06-app-eshop/index.php) - výpis zboží v e-shopu.
    - [buy.php](./06-app-eshop/buy.php) - přidání zboží do košíku dle ID
    - [remove.php](./06-app-eshop/remove.php) - smazání zboží z košíku
    - [cart.php](./06-app-eshop/cart.php) - výpis zboží přidaného do košíku
    - [logout.php](./06-app-eshop/logout.php) - simulace odhlášení, zruší session
    - [me.php](./06-app-eshop/me.php) - údaje o uživateli (demonstrace práce s cookies)
- část aplikace pro její správce:
    - [new.php](./06-app-eshop/new.php) - přidání nového zboží do e-shopu, začne se nabízet ke koupi
    - [delete.php](./06-app-eshop/delete.php) - smazání zboží z e-shopu, přestane se nabízet ke koupi
    - [update.php](./06-app-eshop/update.php) - úprava zboží v e-shopu

:point_right:

Výzva k zamyšlení:
- *Zvládli byste předělat přihlašování tak, aby se data o uživateli ukládala do session?*
    
### Domácí úkol
:house:    

> Domácí úkol vychází z ukázkové aplikace [jednoduchého e-shopu](./06-app-eshop).
> Vaším úkolem je:
> - spustit aplikaci na serveru eso.vse.cz *(0,5 bodu)*
> - upravit aplikaci tak, aby bylo možné do košíku přidat více kusů od každého druhu zboží *(1,5 bodu)*
>
> **Způsob a termín odevzdání:**
> - Vytvořenou aplikaci nahrajte na server eso.vse.cz a odkaz na ni vložte do příslušného zadání v MS Teams.
