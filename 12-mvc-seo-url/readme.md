# 12. MVC, SEO URL

:no_entry: **TYTO PODKLADY BUDOU TEPRVE AKTUALIZOVÁNY** :no_entry:

:point_right:

TODO opakování

---

:point_right:

**Na tomto cvičení nás čeká:**
- [.htaccess](#htaccess)
- [objektový přístup k vývoji aplikací, MVC](#objektov%C3%BD-p%C5%99%C3%ADstup-k-v%C3%BDvoji-mvc)
- [ukázkové objektové aplikace](#uk%C3%A1zkov%C3%A9-objektov%C3%A9-aplikace)

--- 

## .htaccess
:point_right:

- jde o konfigurační soubor pro úpravu nastavení serveru Apache (na kterém je PHP ve většině případů provozováno)
- ovlivňuje nastavení serveru pro daný adresář a jeho podadresáře
- v případě spuštění PHP jako modulu v Apache lze v rámci něj měnit i nastavení PHP
- zatím jsme tento soubor použili pro jednoduchou HTTP autentifikaci - [viz cvičení 08](../08-uzivatele-maily/08-htpasswd)
- POZOR: možnosti, které jsou 

### Mod Rewrite
:point_right:

Pomocí tohoto módu můžeme serveru zařídit, aby server poslal jako odpověď jiný soubor, než jaký byl uveden v HTTP požadavku.
- výsledkem vyhodnocení může být buď **přesměrování** (např. z adresy bez *www* na verzi s ní),
- nebo tzv. **podstrkávání** - tj. varianta, pomocí které se dělají hezké adresy (např. adresa */produkty/produktA* vede ve skutečnosti na PHP skript, který daný produkt načte z databáze a zobrazí jej) 

:point_right:

#### Základní zápis mod rewrite v .htaccessu
```apache
RewriteEngine on
RewriteBase /10-htaccess

RewriteCond selektorPodminky podminka
RewriteRule pozadovanaUrl vracenySkript [modifikátory]
```

- část ```RewriteCond``` slouží pro složitější podmínky, např. použitý protokol serveru atp.
- základní přesměrovávací pravidla se zapisují jen pomocí ```RewriteRule```, v hranatých závorkách se za pravidlem uvádějí tzv. modifikátory
    - při větším množství se modifikátory oddělují čárkou
    - doporučené modifikátory
        - **R** - přesměrování (bez jeho uvedení jde o "podstrkávání" - uživatel se nedozví, že server vrací něco jiného, než je požadováno)
        - **R=301** - redirect permanent
        - **QSA** - k výsledné URL bude připojena původní část za otazníkem
        - **L** - poslední přesměrování v seznamu
        - **F** - zakázání získání souboru

:blue_book:
- [příklad .htaccess - SEO URL](./12-htaccess/seo-url)
- [další příklady rewritu v .htaccessu](./12-htaccess/rewrite/.htaccess)
- [zabezpečení pomocí rewritu v .htaccessu](./12-htaccess/rewrite-security/.htaccess)

### Další nastavení v .htaccessu
:point_right:

Kromě hezkých adres se .htaccess používá také k definici HTTP hlaviček, úpravě nastavení PHP, nastavení chybových dokumentů atp. V následujícím seznamu najdete pár příkladů.

:blue_book:
- [příklad přidání hlaviček do výstupu](./12-htaccess/headers/.htaccess)
- [příklad konfigurace PHP](./12-htaccess/php/.htaccess)
- [příklad zapnutí gzip komprese](./12-htaccess/komprese/.htaccess)
- [příklad zakázání přístupu](./12-htaccess/allow-deny/.htaccess)
- [příklad chybové dokumenty](./12-htaccess/error-document/.htaccess)


## Objektový přístup k vývoji, MVC
:point_right:

TODO

## Ukázkové objektové aplikace
:point_right:

TODO

:point_right:

### MVC aplikace implementované bez frameworku
:point_right:

TODO


### Aplikace implementované v Nette
:point_right:

TODO


### Příprava ke spuštění ukázkových aplikací:
:point_right:
1. naimportujte [SQL export](./12-db.sql) do databáze 
2. nahrajte na server eso.vse.cz podklady k dnešnímu cvičení

### Aplikace Články
:point_right:
- jde o jednoduchou objektovou aplikaci, která načítá články z databáze a zobrazuje je na webu
- data jsou v modelu načítána bez vytváření konkrétních entit (instancí konkrétních entitních tříd)
- pozor: *pro spuštění Nette aplikace je potřeba načíst její podadresář www* (tj. například http://eso.vse.cz/~xname/10-blog-nette/www)

:blue_book:
- [aplikace Články implementovaná v MVC bez použití frameworku](./12-clanky-mvc)
- [aplikace Články implementovaná v Nette](./12-clanky-nette)

### Aplikace Blog
:point_right:
- jde o příklad jednoduchého blogu zobrazujícího články dle kategorií
- aplikace obsahuje autentizaci a autorizaci uživatelů
- jsou využívány definované entitní třídy pro články, kategorie, uživatele atd.
- pro vyzkoušení této aplikace jsou k dispozici uživatelské účty:
    - e-mail "xadmin@vse.cz", heslo "xadmin"
    - e-mail "xname@vse.cz", heslo "xname"

:blue_book:
- [aplikace Blog implementovaná v MVC bez použití frameworku](./12-blog-mvc)
- [aplikace Blog implementovaná v Nette](./12-blog-nette) 