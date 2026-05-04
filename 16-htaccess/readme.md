# 16. htaccess
:point_right:

- jde o konfigurační soubor pro úpravu chování webového serveru Apache (na kterém je PHP ve většině případů provozováno)
- ovlivňuje nastavení serveru pro daný adresář a jeho podadresáře
- v případě spuštění PHP jako modulu v Apache lze v rámci něj měnit i nastavení PHP
- protože se `.htaccess` načítá při každém požadavku, jeho nadměrné používání může mít vliv na výkon aplikace
- zatím jsme tento soubor použili pro jednoduchou [HTTP autentifikaci](../10-uzivatele/10-htpasswd)
- často se používá také pro zabezpečení aplikace (např. blokování přístupu k citlivým souborům)

:grey_disclaimer:
Možnosti, které jsou v .htaccessu dostupné, se liší podle konfigurace serveru.
- Pokud je v něm uvedena direktiva, kterou není možné na daném serveru použít, místo daného webu se nám zobrazí buď chyba v konfiguraci serveru, nebo vůbec nic. Pak je variantou postupně povolovat jednotlivé direktivy až k té, která není funkční.
- Pokud nemůžeme direktivu měnit, nemůžeme ji v .htaccessu uvést ani v případě, že bychom ji chtěli změnit na hodnotu, kterou už má.  

## Mod Rewrite
:point_right:

- umožňuje přepsat URL požadavku na jiný interní skript nebo provést přesměrování
- výsledkem vyhodnocení může být buď **přesměrování** (redirect) - např. z adresy bez *www* na verzi s ní,
- nebo tzv. **podstrkávání** (rewrite) - tj. varianta, pomocí které se dělají hezké adresy (např. adresa */produkty/produktA* vede ve skutečnosti na PHP skript, který daný produkt načte z databáze a zobrazí jej) 

:grey_exclamation:
- přepis URL (rewrite) a přesměrování (redirect) jsou dvě různé věci:
    - rewrite - změna probíhá na serveru (uživatel ji nevidí)
    - redirect - prohlížeč je přesměrován na jinou URL

:point_right:

### Základní zápis mod rewrite v .htaccessu
```apache
RewriteEngine on
RewriteBase /10-htaccess

RewriteCond selektorPodminky podminka
RewriteRule pozadovanaUrl vracenySkript [modifikátory]
```

- část ```RewriteCond``` slouží pro definici podmínek (např. HTTPS, doména, existence souboru apod.)
- základní přesměrovávací pravidla se zapisují jen pomocí ```RewriteRule```, v hranatých závorkách se za pravidlem uvádějí tzv. modifikátory
    - při větším množství se modifikátory oddělují čárkou
    - doporučené modifikátory
        - **R** - přesměrování (bez jeho uvedení jde o "podstrkávání" - uživatel se nedozví, že server vrací něco jiného, než je požadováno)
        - **R=301** - redirect permanent
        - **QSA** - k výsledné URL bude připojena původní část za otazníkem
        - **L** - poslední přesměrování v seznamu
        - **F** - zakázání získání souboru
        - **NC** - case insensitive (ignoruje velikost písmen)

:blue_book:
- [příklad .htaccess - SEO URL](./16-htaccess-priklady/seo-url)
- [další příklady rewritu v .htaccessu](./16-htaccess-priklady/rewrite/.htaccess)
- [zabezpečení pomocí rewritu v .htaccessu](./16-htaccess-priklady/rewrite-security/.htaccess)

## Další nastavení v .htaccessu
:point_right:

Kromě hezkých adres se .htaccess používá také k definici HTTP hlaviček, úpravě nastavení PHP, nastavení chybových dokumentů atp. V následujícím seznamu najdete pár příkladů.

:blue_book:
- [příklad přidání hlaviček do výstupu](./16-htaccess-priklady/headers/.htaccess)
- [příklad konfigurace PHP](./16-htaccess-priklady/php/.htaccess)
- [příklad zapnutí gzip komprese](./16-htaccess-priklady/komprese/.htaccess)
- [příklad zakázání přístupu](./16-htaccess-priklady/allow-deny/.htaccess)
- [příklad chybové dokumenty](./16-htaccess-priklady/error-document/.htaccess)