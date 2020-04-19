# 12. MVC, SEO URL

:no_entry: **TYTO PODKLADY BUDOU TEPRVE AKTUALIZOVÁNY** :no_entry:

:grey_exclamation: **Tato složka obsahuje podklady k domácímu studiu ke cvičením 14. a  15. 5. 2020.**
Oproti běžným podkladům ke cvičením zde naleznete podrobnější vysvětlení dané problematiky a další příklady.

## Stručná rekapitulace
:point_right:

Úspěšně jsme se dopracovali až na konec semestru a umíme toho už docela dost. Namátkou bychom kromě úplných základů PHP bychom mohli připomenout:
- zpracování formulářů včetně kontrol a ošetření vstupů,
- definici tříd a jejich použití v aplikaci,
- práci se soubory i s databází,
- či například implementaci uživatelských účtů.

Jenže to nestačí, abychom mohli říct, že umíme psát aplikace v PHP

:point_right:

**Většina nových aplikací v PHP se dnes píše objektově a používá hezké URL.** 
- vlastně všechny byť jen trochu složitější aplikace
- i v případě neobjektových aplikací je kladen důraz na oddělení business logiky aplikace od prezentační vrstvy (např. za využití šablonovacího systému)

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
- POZOR: Možnosti, které jsou v .htaccessu dostupné, se liší podle konfigurace serveru.
    - Pokud je v něm uvedena direktiva, kterou není možné na daném serveru použít, místo daného webu se nám zobrazí buď chyba v konfiguraci serveru, nebo vůbec nic. Pak je variantou postupně povolovat jednotlivé direktivy až k té, která není funkční.
    - Pokud nemůžeme direktivu měnit, nemůžeme ji v .htaccessu uvést ani v případě, že bychom ji chtěli změnit na hodnotu, kterou už má.  

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

Stejně jako např. v Javě, i v PHP obvykle využíváme pro vývoj objektových aplikací návrhových vzorů. Vývoj v PHP má ale samozřejmě svá specifika, která bychom si měli představit. A zopakujeme si také vlastnosti MVC (ačkoliv si jej jistě pamatujete ze základního kurzu javy :)).

### Model-View-Controller, respektive Model-View-Presenter
:point_right:
- = 2 podobné návrhové vzory, které se používají ke vzájemnému oddělení datové a prezentační logiky aplikace
    -  se dá říct, že z MVC postupně vznikly další návrhové vzory - nejen MVP, ale např. také MVVM
    - rozdíl mezi MVC a MVP je ve způsobu předávání dat mezi *modelem* a *view*, případě PHP aplikací se ale názvy v různých frameworcích atp. používají celkem "volně"
- **controller/presenter**
    - má za úkol rozhodnout, co se vlastně bude provádět (jaká akce)
    - v PHP aplikacích má na starost ošetření vstupu
    - v souvislosti s postupným vývojem návrhových vzorů využívaných pro web je korektnější označení *presenter*
        - přímo ovlivňuje view, presenter obsahuje aplikační i prezentační logiku aplikace
        - je obvyklé, aby controller/presenter vybral data z modelu a předal je do view (což zjednodušuje funkcionalitu view, které pak v podstatě plní funkci chytřejší šablony)
- **view**
    - stará se o zobrazení dat uživateli
    - interaguje s uživatelem (např. po kliknutí na odkaz dojde k vyvolání konkrétní akce)
- **model**
    - část mající za úkol pracovat s daty (s dabází, soubory atd.)
    - obsahuje značnou část business logiky
    - v pokročilejších implementacích se model dál dělí do vrstev (mluvíme o *"vícevrstvém modelu"*)
        - pro práci s databází to může vypadat např. tak, že máme
            - repository (třída pracující přímo s databází)
            - mapper (třída zajišťující mapování objektů na databázové entity)
            - facade (třída zprostředkovávající funkcionalitu modelu pro controller/view)    
- Výhodou použití MVC/MVP je to, že lze v případě potřeby upravit jen konkrétní vrstvu. V souvislosti s využíváním frameworků pro objektově-relační mapování pak mají jednotlivé třídy minimalistickou implementaci (většinu věcí buď dědí od nějaké generické třídy, nebo využíváme konfiguraci pomocí anotací v komentářích).

:blue_book:
- [MVC a další návrhové vzory - zdroják.cz](https://www.zdrojak.cz/serialy/mvc-a-dalsi-prezentacni-vzory/)

### Specifika vývoje v PHP
:point_right:

Jak už jsme zjistili, PHP neběží na serveru trvale, ale slouží jen k vyřízení konkrétního požadavku (narozdíl např. od Javy). Z toho vyplývají základní vlastnosti PHP aplikace:
- není možné mít pracovní data konkrétního uživatele trvale umístěná v rámci tříd
    - v porovnání např. s "adventurou", kterou jste psali na Javových kurzech, nemůžete uchovávat předměty sesbírané uživatelem v proměnné v modelu - protože po vyřízení požadavku na zobrazení konkrétní stránky přestane instance modelu existovat
- výhodou je to, že samotný základ aplikace je při každém požadavku ve stejném stavu
- nevýhodou je to, že nemůžeme nechat aplikaci něco počítat či řešit na pozadí a jen se dotazovat na výsledky        
- pro předávání dat mezi jednotlivými požadavky používám *session*, *databází*, případně *soubory na serveru*

### Obvyklý "průchod" objektovou aplikací v PHP
:point_right:
1. všechny požadavky jsou předávány na 1 vstupní soubor (*bootstrap.php*, *index.php* atp.)
    - přesměrování všech požadavků na tento soubor zařídí *.htaccess*
    - dojde k základní inicializaci aplikace, načtení *autoloadu* atp.
2. dojde k namapování požadavku na konkrétní controller(presenter) a konkrétní akci
3. dojde k ověření, zda má daný uživatel právo spustit danou akci
4. je vytvořen příslušný presenter(controller) a na něm je spuštěna daná akce
    - presenter obvykle požaduje přístup k danému modelu
    - presenter určuje, jaké view bude využito
    - presenter řídí zpracování uživatelského vstupu, spouští metody modelu atp.
    - v případě speciálních oprávnění zároveň ověřuje práva uživatele (např. zda může uživatel editovat jen vlastní článek v CMS)
5. view prezentuje data uživateli
6. celá aplikace je uvolněna z paměti
    - pro zrychlení dalších průchodů se obvykle využívá cache

## Ukázkové objektové aplikace
:point_right:

Pro možnost porovnání vývoje s frameworkem a bez něj najdete v podkladech ke dnešnímu cvičení aplikace Články a Blog, které jsou implementované ve dvou variantách - jednak ve vlastní objektové implementaci za využití návrhového vzoru MVC a poté za využití frameworku Nette, který využívá návrhový vzor MVP.
Kód obou implementací je záměrně napsán tak, aby s vzájemně co nejvíce odpovídal.

### MVC aplikace implementované bez frameworku
:point_right:
- jednoduchá ukázka ruční implementace MVC
- pro získání instancí tříd modelu je využit návrhový vzor **singleton** (který už také znáte z Javy...)
    - lepší alternativou by byla implementace *automatického injection* přístupu (tj. automatického načítání potřebných závislostí pro třídy, což moc nejde bez konstrukcí, které jsou pro tento kurz zbytečně složité)
    - rovnocennou alternativou je implementace návrhového vzoru *registry*
        - jedna třída slouží ke shromažďování již vytvořených instancí (např. v asociačním poli), které je možné získat dle jejich názvu/typu

### Aplikace implementované v Nette
:point_right:
- Co je to *Nette*?
    - = český PHP framework, populární nejen v Čechách, ale v souvislosti s českými autory má velmi dobrou komunitní podporu
    - více info na webu [https://nette.org/cs/](https://nette.org/cs/)
    - má některé zajímavé funkce, které zjednodušují vývoj aplikace - např.:
        - vůbec nemusíte řešit, jaké budou adresy v aplikaci
            - odkazujete se vždycky na konkrétní presenter a jeho akci, parametry předáváte jako pole
            - URL se z toho seskládají pomocí *routeru* (třída definující překlad adres)
        - jednoduchá možnost následného zAJAXovatění aplikace
        - není závislý na jedné konkrétní databázové vrstvě
        - má Tracy - nástroj pro opravdu přehledné vysvětlování chyb
        - všechny šablony se píší v *latte* (šablonovací systém podobný např. *smarty*), který za vás zajistí bezpečnost znaků na výstupu
        - pokud využijete trait Nette\SmartObject, je podporováno využívání properties á la c#
        - nezáleží na přesném umístění tříd v souborech, autoload najde všechny třídy, které umístíte do adresáře s aplikací
- v rámci ukázkových aplikací *záměrně využíváme pro práci s databází jen PDO*
    - už ho známe a umíme s ním pracovat
    - pokud byste chtěli něco s většími možnostmi, tak v Nette je vlastní databázová vrstva, případně se dá používat nějaká vrstva pro objektově-relační mapování (asi nejznámnější je [Doctrine](https://www.doctrine-project.org/), či lze využít např. jednoduchý [LeanMapper](https://leanmapper.com/)

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

---

## Zakončení předmětu
:point_right:

Jelikož máme poslední cvičení, je vhodné si připomenout, co vše musíte splnit pro úspěšné zakončení tohoto předmětu:
- absolvovat test (z témat probíraných na přednáškách)
- napsat a následně obhájit databázovou aplikaci v PHP

Obecné požadavky jsou uvedeny [na webu předmětu](https://4iz278.github.io/zakonceni/). 

### Obhajoby PHP aplikací v letním semestru 2019/2020
:key: 

**Obhajoby budou probíhat přes MS Teams za následujících podmínek:**
- k obhajobě je nutné se přihlásit prostřednictvím systém InSIS
- vaše PHP aplikace musí být dostupná přes internet
- na začátku obhajoby bude nutné se připojit přes webkameru a pomocí ukázání školní karty či OP prokázat svoji totožnost
- následně bude potřeba nasdílet vlastní obrazovku s promítnutím aplikace a zdrojového kódu 