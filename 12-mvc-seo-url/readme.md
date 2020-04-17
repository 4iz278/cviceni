# 12. MVC, SEO URL

:no_entry: **TYTO PODKLADY BUDOU TEPRVE AKTUALIZOVÁNY** :no_entry:

:point_right:

TODO opakování

---

:point_right:

**Na tomto cvičení nás čeká:**
- [.htaccess (a hezké SEO adresy)](#htaccess)
- [objektový přístup k vývoji aplikací, MVC](#objektov%C3%BD-p%C5%99%C3%ADstup-k-v%C3%BDvoji-mvc)
- [ukázkové objektové aplikace](#uk%C3%A1zkov%C3%A9-objektov%C3%A9-aplikace)

--- 

## .htaccess
:point_right:

TODO

## Objektový přístup k vývoji, MVC
:point_right:

TODO

## Ukázkové objektové aplikace
:point_right:

TODO


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
