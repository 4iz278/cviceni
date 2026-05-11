# 17. Objektový vývoj aplikací, MVC

:point_right:

Stejně jako v řadě jiných programovacích jazyků používáme i v PHP při návrhu větších aplikací objektový přístup a návrhové vzory.

## Model-View-Controller, respektive Model-View-Presenter
:point_right:
- = 2 podobné návrhové vzory, které se používají ke vzájemnému oddělení aplikační logiky, prezentační vrstvy a práce s daty
- k MVC existuje větší množství příbuzných architektonických vzorů, např. MVP nebo MVVM
- rozdíl mezi MVC a MVP je ve způsobu předávání dat mezi *modelem* a *view*, případě PHP aplikací se ale názvy v různých frameworcích atp. používají celkem "volně"

:point_right:
- **controller/presenter**
  - zpracovává požadavek uživatele a rozhoduje, jaká akce aplikace se provede
  - pracuje se vstupy - typicky zpracovává parametry z URL, formulářů nebo API požadavků
  - některé PHP frameworky používají místo označení controller pojem *presenter*
  - přímo ovlivňuje view, presenter obsahuje aplikační i prezentační logiku aplikace
  - je obvyklé, aby controller/presenter vybral data z modelu a předal je do view (což zjednodušuje funkcionalitu view, které pak v podstatě plní funkci chytřejší šablony)
- **view**
  - stará se o zobrazení dat uživateli
  - interaguje s uživatelem (např. po kliknutí na odkaz dojde k vyvolání konkrétní akce)
  - view by ideálně nemělo obsahovat business logiku aplikace
- **model**
    - část mající za úkol pracovat s daty (s databází, soubory atd.)
    - obsahuje značnou část business logiky
    - v rozsáhlejších aplikacích bývá model rozdělen do více vrstev (mluvíme o *"vícevrstvém modelu"*)
      - pro práci s databází to může vypadat např. tak, že máme
        - repository (třída pracující přímo s databází)
        - mapper / ORM vrstva (třída zajišťující mapování objektů na databázové entity)
        - facade (třída zprostředkovávající funkcionalitu modelu pro controller/view)    
- Výhodou použití MVC/MVP je to, že lze v případě potřeby upravit jen konkrétní vrstvu. V souvislosti s využíváním frameworků pro objektově-relační mapování pak mají jednotlivé třídy minimalistickou implementaci (většinu věcí buď dědí od nějaké generické třídy, nebo využíváme konfiguraci pomocí anotací v komentářích).

:blue_book:
- [MVC a další návrhové vzory - zdroják.cz](https://www.zdrojak.cz/serialy/mvc-a-dalsi-prezentacni-vzory/)

## Specifika vývoje v PHP
:point_right:

Jak už jsme zjistili, v běžném webovém provozu neběží PHP na serveru trvale, ale slouží jen k vyřízení konkrétního požadavku (narozdíl např. od Javy). Z toho vyplývají základní vlastnosti PHP aplikace:
- data konkrétního uživatele nemůžeme dlouhodobě uchovávat pouze v instancích tříd (např. v modelu)
- výhodou je, že aplikace začíná každý požadavek v čistém výchozím stavu
- dlouhodobé úlohy se obvykle neřeší přímo v rámci HTTP požadavku, ale pomocí samostatných procesů, front nebo plánovaných úloh
- pro předávání dat mezi jednotlivými požadavky používáme *session*, *databázi*, případně *soubory na serveru*

## Obvyklý "průchod" objektovou aplikací v PHP
:point_right:
1. všechny požadavky jsou předávány na 1 vstupní soubor (*bootstrap.php*, *index.php* atp.)
    - přesměrování všech požadavků na tento soubor zařídí *.htaccess*
    - dojde k základní inicializaci aplikace, načtení *autoloadu* atp.
2. dojde k namapování požadavku na konkrétní controller(presenter) a konkrétní akci
    - mapování obvykle zajišťuje router
3. dojde k ověření, zda má daný uživatel právo spustit danou akci
4. je vytvořen příslušný controller/presenter a na něm je spuštěna daná akce; controller/presteter:
    - obvykle spolupracuje s modelem
    - předává data do view (často také určuje, jaké view bude využito)
    - řídí zpracování uživatelského vstupu, spouští metody modelu atp.
    - v případě potřeby zároveň ověřuje oprávnění uživatele (např. zda může uživatel editovat jen vlastní článek v CMS)
5. view prezentuje data uživateli
6. celá aplikace je uvolněna z paměti
    - pro zrychlení dalších průchodů se často využívá cache

## Ukázkové objektové aplikace
:point_right:

Pro možnost porovnání vývoje s frameworkem a bez něj najdete v podkladech aplikace Články a Blog, které jsou implementované ve dvou variantách - jednak ve vlastní objektové implementaci za využití návrhového vzoru MVC a poté za využití frameworku Nette, který využívá návrhový vzor MVP.
Kód obou implementací je záměrně napsán tak, aby si byly co nejvíce podobné.

### MVC aplikace implementované bez frameworku
:point_right:
- jednoduchá ukázka vlastní implementace MVC architektury bez frameworku
- pro získání instancí tříd modelu je využit návrhový vzor **singleton**
    - lepší alternativou by byla implementace *automatického injection* přístupu (tj. automatického načítání potřebných závislostí pro třídy, což moc nejde bez konstrukcí, které jsou pro tento kurz zbytečně složité)
    - rovnocennou alternativou je implementace návrhového vzoru *registry*
      - registry = centrální objekt uchovávající vytvořené instance služeb
      - často jeden objekt sloužící ke shromažďování již vytvořených instancí (např. v asociačním poli), které je možné získat dle jejich názvu/typu
    - v moderních aplikacích se častěji používá dependency injection kontejner - viz Nette

### Aplikace implementované v Nette
:point_right:
- Co je to *Nette*?
  - = český PHP framework s dlouhou historií a silnou komunitou
  - více info na webu [https://nette.org/cs/](https://nette.org/cs/)
  - má některé zajímavé funkce, které zjednodušují vývoj aplikace - např.:
    - vůbec nemusíte řešit, jaké budou adresy v aplikaci
      - odkazujete se vždycky na konkrétní presenter a jeho akci, parametry předáváte jako pole
      - URL adresy generuje *router* na základě definovaných pravidel
    - podpora jednoduché implementace AJAXových požadavků
    - není závislý na jedné konkrétní databázové vrstvě
    - má Tracy - pokročilý debugovací nástroj pro výpis chyb a diagnostiku aplikace
    - všechny šablony se píší v *latte* (šablonovací systém podobný např. *smarty*), který za vás zajistí bezpečnost znaků na výstupu
      - automaticky escapuje výstup, čímž pomáhá chránit aplikaci proti XSS útokům
    - třídy jsou automaticky načítány pomocí autoloadu
- v rámci ukázkových aplikací *záměrně využíváme pro práci s databází jen PDO*
    - už ho známe a umíme s ním pracovat
    - pokud byste chtěli něco s většími možnostmi, tak v Nette je vlastní databázová vrstva
    - pro pokročilejší práci s databází lze využít ORM frameworky
      - asi nejznámější je [Doctrine](https://www.doctrine-project.org/), či lze využít např. jednoduchý [LeanMapper](https://leanmapper.com/)

:grey_exclamation:
- framework neřeší jen architekturu aplikace, ale také routování, bezpečnost, konfiguraci, práci s formuláři, cache a další opakující se problémy

### Příprava ke spuštění ukázkových aplikací:
:point_right:
1. naimportujte [SQL export](./17-db.sql) do databáze 
2. nahrajte na server eso.vse.cz podklady k dnešnímu cvičení
3. u aplikací bez frameworku upravte přístupy/adresy v souborech:
    - `.htaccess`
    - `application/config.php`
4. v případě aplikací v Nette
    - upravte nastavení v souboru `app/config/local.neon`
    - povolte zápis (práva 777) pro adresáře `log` a `temp`

### Aplikace Články
:point_right:
- jde o jednoduchou objektovou aplikaci, která načítá články z databáze a zobrazuje je na webu
- data jsou v modelu načítána bez vytváření konkrétních entit (instancí konkrétních entitních tříd)
- veřejná data jsou ve složce www, pro servery apache je zde nastavené podsunutí dat pomocí souboru .htaccess

:blue_book:
- [aplikace Články implementovaná v MVC bez použití frameworku](./17-clanky-mvc)
- [aplikace Články implementovaná v Nette](./17-clanky-nette)

### Aplikace Blog
:point_right:
- jde o příklad jednoduchého blogu zobrazujícího články dle kategorií
- aplikace obsahuje autentizaci a autorizaci uživatelů
- jsou využívány definované entitní třídy pro články, kategorie, uživatele atd.
- pro vyzkoušení této aplikace jsou k dispozici uživatelské účty:
    - e-mail "xadmin@vse.cz", heslo "xadmin"
    - e-mail "xname@vse.cz", heslo "xname"

:blue_book:
- [aplikace Blog implementovaná v MVC bez použití frameworku](./17-blog-mvc)
- [aplikace Blog implementovaná v Nette](./17-blog-nette)
- pokud byste potřebovali při testování změn smazat cache (zejména na eso.vse.cz), načtěte z webu soubor [deleteCacheDir.php](./12-blog-nette/deleteCacheDir.php)