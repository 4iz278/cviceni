# 6. Cookies a session

- Zatím jsme pracovali s PHP zcela bezstavově, ale často je nutné, aby se nějaká data z předchozího požadavku přenášela i do toho dalšího - např. v e-shopu chce uživatel zboží přidávat do košíku, nebo se chce na webu přihlásit...
  - nechceme vždy posílat všechna data v URL či ve formuláři
  - řešením pro použití přímo z PHP mohou být cookies a session proměnné.

## Cookies

:point_right:

**Cookies nejsou jen "sušenky", ale také jednoduchý způsob uložení informací v prohlížeči ve tvaru klíč = hodnota.**
- Server (PHP) odešle HTTP hlavičku s instrukcí pro uložení cookie. Prohlížeč si tyto informace zapamatuje a posílá danou cookie na server při každém dalším požadavku na danou doménu.
    - Když si uložíme cookie požadavkem ze souboru index.php, tak se pošle na server při všech požadavcích na další skripty, obrázky atp. (tj. přenáší se opravdu v každém požadavku). **Do cookies ukládáme jen opravdu malé objemy informací.**
- Cookies mohou být dostupné jak z javascriptu, tak také ze serveru. Zrovna tak je ale uživatel může v prohlížeči kompletně zakázat.
- Cookies mohou mít omezenou platnost (po jejím vypršení je prohlížeč smaže).
- Maximální velikost jedné cookie je cca 4 kB, ale čím menší, tím lépe. 
- Pokud používáme cookies pro trasování uživatele (sledování jeho chování na webu), je nutné mít jeho souhlas.
  - pro trasování se do cookies ukládají identifikátory, ne data o procházených stránkách!

:grey_exclamation: Cookies nejsou bezpečné úložiště!
- uživatel je může v prohlížeči jednoduše změnit či smazat
- nelze jim věřit (např. pro ukládání role uživatele)
- citlivá data ukládáme raději na server (session)
    
:point_right:

- Pro nastavení cookies používáme funkci ```setcookie()```, která nám sestaví a odešle příslušnou HTTP hlavičku s nastavením. Stejně jako např. funkci ```header()``` musíme i nastavení cookies volat před začátkem odesílání HTML obsahu (jako třeba u přesměrování po odeslání formuláře).
    
```php
setcookie('cookie1', 'hodnota', time() + 3600); //ukládáme cookie s platností 1 hodinu
setcookie('cookie2', 'hodnota', time() + 3600*24, "/xname/"); //ukládáme cookie s platností 1 den, která bude dostupná jen pro adresář /xname/

setcookie('cookie3', 'hodnota', [ //novější varianta nastavení pomocí pole
  'expires' => time() + 3600,
  'path' => '/',
  'httponly' => true,
  'samesite' => 'Lax'
]);
```

:point_right:
Nastavení pro větší bezpečnost:
- httponly = cookie není dostupná z JavaScriptu (ochrana proti XSS)
- samesite = omezuje odesílání cookie mezi doménami (ochrana proti CSRF)

:point_right:
- Pro čtení máme cookies dostupné kdekoliv ve skriptu v globální proměnné ```$_COOKIE```.
  - Pozor, přepsáním hodnoty v tomto poli se žádná cookie neuloží!
  - Nově nastavená cookie není dostupná v poli $_COOKIE ve stejném requestu, ale až při následujícím požadavku.

```php
echo $_COOKIE['cookie1'] ?? ''; //výpis cookie
```

:blue_book:
- [Funkce setcookie() na w3schools.com](https://www.w3schools.com/php/func_network_setcookie.asp)
- [Funkce setcookie() v PHP manuálu](https://www.php.net/manual/en/function.setcookie.php)

## Session

:point_right:

Jak už bylo zmíněno, při činnosti aplikace velmi často potřebujeme vědět, jaké požadavky odeslal uživatel před tím současným (například zda se přihlásil, co přidal do košíku atp.). Tyto informace potřebujeme na straně serveru a také potřebujeme, aby je uživatel nemohl jednoduše podvrhnout (například nám tvrdit, že je přihlášený, ačkoliv není). 
A právě k tomu se velmi hodí SESSION - což je vlastně datové pole, které si můžeme uchovávat na serveru a je dostupné všem následně volaným PHP skriptům.

- V reálu jde o místo (na disku, v paměti atp.), které je označeno unikátním ID uživatele a do kterého si můžeme ukládat informace, které chceme mít dostupné i na další stránce.
- Samotné ID pro identifikaci session se ukládá do cookie (nebo se případně přidává jako parametr do URL, což se dnes z bezpečnostních důvodů nedoporučuje).
- To, že si aplikace pamatuje například přihlášeného uživatele, je věcí vývojáře. Server jen zpřístupní pole s daty podle ID, které obdržel v rámci požadavku uživatele.

:point_right:

- Kdykoliv chceme v PHP session použít, musíme ji nejprve **nastartovat pomocí funkce** ```session_start()```, kterou zavoláme před začátkem odesílání obsahu - tj. na každé stránce, která má session používat. 
  - Pokud pro daného uživatele ještě session nemáme, odešle se do prohlížeče požadavek na uložení cookie *PHPSESSID* s náhodně generovaným řetězcem, který je těžké odhadnout. Zároveň se nám zpřístupní globální pole ```$_SESSION``` pro ukládání informací na serveru.
  - Pokud uživatel již ve svém požadavku odešle na server *PHPSESSID*, načtou se do pole ```$_SESSION``` hodnoty, které v něm byl při předchozím požadavku.       

:point_right:

- **Data v session** máme v PHP přístupná v globálním poli ```$_SESSION```.
- Jde o normální asociační pole, do kterého můžeme informace ukládat kdekoliv v rámci skriptu.
- Pokud do session chceme ukládat objekty, musí být serializovatelné (viz [Serializace objektů](../06-objekty-II#serializace-a-usp%C3%A1v%C3%A1n%C3%AD-objekt%C5%AF)) 

```php
session_start(); //nastartování session

$_SESSION['uzivatel']='jmeno'; // zápis hodnoty do session
echo $_SESSION['pocet_pristupu'];// načtení hodnoty ze session
unset($_SESSION['x']); //smazání hodnoty ze session
```

:point_right:

- Pokud budeme chtít session ukončit, zavoláme funkci ```session_destroy()```.
  - Dojde ke smazání dat o session na straně serveru
  - Cookie v prohlížeči zůstane, ale k danému *PHPSESSID* již nejsou přiřazena žádná data. Pro úplné ukončení lze odstranit cookie na straně klienta (ručně se to ale většinou nedělá).
- Pokud jen budeme chtít změnit hodnotu *PHPSESSID*, zavoláme funkci ```session_regenerate_id()```.
    - Tuto funkci používáme např. po přihlášení uživatele, aby nebylo možné zneužít existující session (ochrana proti session fixation).

### Základní pohled na proces práce se session
:point_right:
Session funguje tak, že:
1. server vytvoří ID
2. uloží data pod tímto ID
3. pošle ID klientovi (cookie)
4. klient při všech dalších requestech posílá dané ID (příslušnou cookie), podle kterých server data načte pro PHP

### Jednoduché vyzkoušení práce se session

:point_right:

Abychom si SESSION nepopisovali jen teoreticky, podívejte se na následující 2 praktické příklady s okomentovaným postupem tvorby.

:orange_book:

Nejpve si vytvoříme jednoduché počítadlo přístupů. Při každém načtení stránky se zvětší hodnota uložená v session.
- [prezentace s postupem řešení](09-pocitadlo-pristupu/prezentace-pocitadlo.pptx)
- [zdrojový kód](09-pocitadlo-pristupu/pocitadlo.php)


:orange_book:

Druhým jednoduchým příkladem je uložení informace z formuláře. Konkrétně půjde o jednoduchý přihlašovací formulář, zatím ale bez ověření uživatele vůči dabázi (o tom až [příště](../07-uzivatele)).
- [prezentace s postupem řešení](09-priklad-prihlaseni/prezentace-priklad-prihlaseni.pptx)
- [zdrojový kód](09-priklad-prihlaseni)

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
- Aplikace využívá session pro nákupní košík a cookies pro uložení jména uživatele v prohlížeči.
- Přihlášení v horní části lišty není skutečné přihlášení, jen ukazuje práci s cookies (jméno uživatele ukládá do cookie v prohlížeči).
- Aplikace zatím nijak neřeší oprávnění uživatelů (všichni mohou vše).  

Zkuste si tuto aplikaci spustit a projděte si okomentované zdrojové kódy.

:blue_book:
- postup zprovoznění ukázkové aplikace:
    1. stáhněte si celou složku aplikace ([09-app-eshop](./09-app-eshop)) a nahrajte ji na server
    2. nahrajte do MariaDB [strukturu databáze](./09-app-eshop/db-schema.sql)
    3. nahrajte do MariaDB [ukázková data](./09-app-eshop/db-data.sql)
    4. nastavte vlastní xname a heslo k databázi v souboru [db.php](./09-app-eshop/inc/db.php)
- část aplikace pro uživatele:
    - [index.php](./09-app-eshop/index.php) - výpis zboží v e-shopu.
    - [buy.php](./09-app-eshop/buy.php) - přidání zboží do košíku dle ID
    - [remove.php](./09-app-eshop/remove.php) - smazání zboží z košíku
    - [cart.php](./09-app-eshop/cart.php) - výpis zboží přidaného do košíku
    - [logout.php](./09-app-eshop/logout.php) - simulace odhlášení, zruší session (odstraní data na serveru)
    - [me.php](./09-app-eshop/me.php) - údaje o uživateli (demonstrace práce s cookies)
- část aplikace pro její správce:
    - [new.php](./09-app-eshop/new.php) - přidání nového zboží do e-shopu, začne se nabízet ke koupi
    - [delete.php](./09-app-eshop/delete.php) - smazání zboží z e-shopu, přestane se nabízet ke koupi
    - [update.php](./09-app-eshop/update.php) - úprava zboží v e-shopu

:grey_exclamation:
V ukázkové aplikaci není řešena autentizace ani oprávnění uživatelů – jde pouze o demonstrační příklad práce s cookies a session.

### Výzva k zamyšlení
:point_right:
- *Zvládli byste předělat přihlašování tak, aby se data o uživateli ukládala do session?*
  - *Co by se změnilo oproti cookies?*
  - *Jak byste řešili odhlášení?*
  - *Kde byste kontrolovali, zda je uživatel přihlášený?*