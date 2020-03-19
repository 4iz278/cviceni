# 5. SQL a databáze

:grey_exclamation: **Tato složka obsahuje podklady k domácímu studiu ke cvičením 26. a 20.3.2020.**
Oproti běžným podkladům ke cvičením zde naleznete podrobnější vysvětlení dané problematiky a další příklady.

## Opakování z minulého cvičení

:point_right:

V rámci [minulého cvičení](../04-objekty-II-validace) byla dokončena problematika používání objektů v PHP, druhá část podkladů pak byla věnována problematice validace formulářů.


:point_right:

Z hlediska **práce s objekty** byste si měli pamatovat:
- již ze 3. cvičení základní informace o definici a používání tříd, jmenných prostorů, rozhraní, dědičnosti, traitů
- z minulého cvičení navíc *magické metody*:
    - všechny začínají na __ (dvě podtržítka) 
    - jsou volány buď v případě speciálních úkonů (konstruktor, převod na string, serializace),
    - nebo umí simulovat neexistující/zpřístupnit private proměnné či metody. 
- *classloader* a *composer*:
    - běžně nenačítáme soubory s definicí tříd ručně pomocí require/include, ale definujeme funkci, která je načte při jejich prvním použití;
        - buď ruční definice pomocí ```spl_autoload_register```,
        - nebo načítání v rámci nějakého frameworku.
    - závislosit načítáme nástrojem *composer*
        - definice pomocí jednoduchého JSON souboru, ve kterém uvedeme, jaké komponenty chceme;
        - composer načítá komponenty buď z https://packagist.org, nebo z GITu;
        - pro načtení všech příslušných tříd stačí načíst vygenerovaný autoload.php.


:point_right:

Z hlediska **validace formulářů**:
- musíme kontrolovat všechna data získaná od uživatele (ať jsme je získali z formuláře, v parametrech v URL či například z nějakého API)!
- u formuláře je sice hezké definovat kontrolu v HTML 5 a v javascriptu, ale stejně musíme kontrolovat data i na serveru,
- uživateli musíme zobrazit konkrétní popisy chyb (buď na jednom místě, nebo u konkrétních polí formuláře), správná data musí zůstat ve formuláři vyplněna;
- po odeslání formuláře metodou POST musí následovat přesměrování pomocí ```header('Location: soubor.php');```

:house:

Připomínám, že součástí byl také [domácí úkol](../04-objekty-II-validace#dom%C3%A1c%C3%AD-%C3%BAkol). Pokud jej máte hotový, nezapomeňte na jeho odevzdání.

---

:point_right:

**Na tomto cvičení nás čeká:**
- opakování základních SQL příkazů pro manipulaci s daty
- vlastnosti MySQL a MariaDB
- práce s nástrojem phpMyAdmin
- připojení k databázi z PHP
- praktická aplikace využívající databázi  

---        

## Základní SQL příkazy pro manipulaci
:point_right:

Předpokládám, že za sebou máte základní kurz věnovaný databázím, tj. SQL v zásadě umíte a základní vlastnosti relačních databází znáte.

**Co po vás budeme chtít?**
- příkazy pro CRUD operace, tj. ```SELECT```, ```INSERT```, ```UPDATE```, ```DELETE```
- umět logicky navrhnout strukturu databáze (naklikat ji)
- vědět, jak se chovají cizí klíče
- vědět, co jsou to transakce

**Co po vás naopak chcít nebudeme?**
- vytváření a úprava tabulek, views atp.
    - protože strukturu databáze většinou definujeme jen při vývoji aplikace a máme možnost si to naklikat v phpMyAdminu
- definice triggerů a dalších pokročilých funkcionalit (samozřejmě je můžete používat, ale jde to i bez nich)
    
## MySQL a MariaDB
:point_right:

TODO    
    
## phpMyAdmin
:point_right:
    
TODO

## Připojení k databází z PHP
:point_right:

TODO

## Praktická aplikace využívající databázi
:orange_book:

TODO

## Domácí úkol
:house:

> TODO