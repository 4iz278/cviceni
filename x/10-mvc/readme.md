# 10. MVC, SEO URL

:no_entry: **TYTO PODKLADY BUDOU TEPRVE AKTUALIZOVÁNY** :no_entry:

* Zbývá nám do konce pár semestru pár cvičení, tak je vhodné shrnout, jak na tom jsme...
    * umíme všechny potřebné jazykové konstrukce v PHP
    * umíme napsat jednoduchou aplikaci
    * umíme pracovat se soubory a s databází

  jenže to nestačí, abychom mohli říct, že umíme psát aplikace v PHP

* **většina nových aplikací v PHP se dnes píše objektově**
    * vlastně všechny, které mají nějakou větší funkcionalitu, než načtení záznamů z DB a jejich zobrazení (co má nějakou administraci atp.)
    * i v případě neobjektových aplikací je kladen důraz na oddělení business logiky aplikace od prezentační vrstvy (např. za využití šablonovacího systému)

---

## Model-View-Controller, respektive Model-View-Presenter
* ale **MVC už známe z Javy**, ne?
* jde o 2 podobné návrhové vzory, které se liší druhem vazeb mezi jednotlivými složkami aplikace
    * obecně se dá říct, že z MVC postupně vznikly další návrhové vzory - nejen MVP, ale např. také MVVM
    * v případě PHP aplikací se názvy v různých frameworcích atp. používají celkem "volně"
* návrhové vzory pro rozdělení aplikace do 3 základních částí
    * **controller/presenter**
        * má za úkol rozhodnout, co se vlastně bude provádět (jaká akce)
        * v PHP aplikacích má na starost ošetření vstupu
        * v souvislosti s postupným vývojem návrhových vzorů využívaných pro web je korektnější označení *presenter*
            * přímo ovlivňuje view, presenter obsahuje aplikační i prezentační logiku aplikace
            * je obvyklé, aby vybralo data z modelu a předalo je do view (což zjednodušuje funkcionalitu view, které pak v podstatě plní funkci chytřejší šablony)
    * **view**
        * stará se o zobrazení dat uživateli
        * interaguje s uživatelem (např. po kliknutí na odkaz dojde k vyvolání konkrétní akce)
    * **model**
        * část mající za úkol pracovat s daty (s dabází, soubory atd.)
        * obsahuje značnou část business logiky
        * v pokročilejších implementacích se model dál dělí do vrstev (mluvíme o *"vícevrstvém modelu"*)
            * pro práci s databází to může vypadat např. tak, že máme
                * repository (třída pracující přímo s databází)
                * mapper (třída zajišťující mapování objektů na databázové entity)
                * facade (třída zprostředkovávající funkcionalitu modelu pro controller/view)

              výhodou je to, že lze v případě potřeby upravit jen konkrétní vrstvu. V souvislosti s využíváním frameworku pro objektově-relační mapování pak mají jednotlivé třídy minimalistickou implementaci (většinu věcí buď dědí od nějaké generické třídy, nebo využíváme konfiguraci pomocí anotací v komentářích)

* další zdroje:
    * [Model-View-Presenter (MVP) - Nette](https://doc.nette.org/cs/0.9/model-view-presenter)
    * [MVC - Zend](http://framework.zend.com/manual/1.12/en/learning.quickstart.intro.html)
    * [MVC a další návrhové vzory - zdroják.cz](https://www.zdrojak.cz/serialy/mvc-a-dalsi-prezentacni-vzory/)

### Specifika vývoje v PHP
* jak už jste asi zjistili, PHP neběží na serveru trvale, ale slouží jen k vyřízení konkrétního požadavku (narozdíl např. od Javy)
    * není možné mít pracovní data konkrétního uživatele trvale umístěná v rámci tříd
        * v porovnání např. s "adventurou", kterou jste psali na Javových kurzech, nemůžete uchovávat předměty sesbírané uživatelem v proměnné v modelu - protože po vyřízení požadavku na zobrazení konkrétní stránky přestane instance modelu existovat
    * pro předávání dat mezi jednotlivými požadavky používám *session*, *databází*, případně *soubory na serveru*

### Obvyklý "průchod" objektovou aplikací v PHP
1. všechny požadavky jsou předávány na 1 vstupní soubor (*bootstrap.php*, *index.php* atp.)
    * přesměrování všech požadavků na tento soubor zařídí *.htaccess*
    * dojde k základní inicializaci aplikace, načtení *autoloadu* atp.
2. dojde k namapování požadavku na konkrétní controller(presenter) a konkrétní akci
3. dojde k ověření, zda má daný uživatel právo spustit danou akci
4. je vytvořen příslušný controller(presenter) a na něm je spuštěna daná akce
    * controller obvykle požaduje přístup k danému modelu
    * controller určuje, jaké view bude využito
    * controller řídí zpracování uživatelského vstupu, spouští metody modelu atp.
    * v případě speciálních oprávnění zároveň ověřuje práva uživatele (např. zda může uživatel editovat jen vlastní článek v CMS)
5. view presentuje data uživateli
6. celá aplikace je uvolněna z paměti
    * pro zrychlení dalších průchodů se obvykle využívá cache

### Praktické příklady
* objektové aplikace pro dnešní cvičení najdete v podkladech ve 2 různých variantách
    * kód je napsaný tak, aby si vzájemně co nejvíc odpovídal

* **ručně implementovaná MVC aplikace**
    * jednoduchá ukázka ruční implementace MVC
    * pro získání instancí tříd modelu je využit návrhový vzor **singleton** (který už také znáte z Javy...)
        * lepší alternativou je implementace *automatického injection* přístupu (což moc nejde bez konstrukcí, které jsou pro tento kurz zbytečně složité)
        * rovnocennou alternativou je implementace návrhového vzoru *registry*
            * jedna třída slouží ke shromažďování již vytvořených instancí (např. v asociačním poli), které je možné získat dle jejich názvu/typu

* **aplikace v Nette**
    * Co je to *Nette*?
        * = český PHP framework, primárně vytvářený Davidem Grundlem a komunitou
        * populární nejen v Čechách, ale v souvislosti s českými autory má velmi dobrou komunitní podporu
        * oproti známějším frameworkům *Zend* či *Symfony* se vyznačuje jednodušším použitím a menšími výpočetními nároky
        * má některé zajímavé funkce, které zjednodušují vývoj aplikace - např.:
            * vůbec nemusíte řešit, jaké budou adresy v aplikaci
                * odkazujete se vždycky na konkrétní presenter a jeho akci, parametry předáváte jako pole
                * URL se z toho seskládají pomocí *routeru* (třída definující překlad adres)
            * jednoduchá možnost následného zAJAXovatění aplikace
            * není závislý na jedné konkrétní databázové vrstvě
            * má Tracy (laděnku) - opravdu přehledné vysvětlování chyb
            * všechny šablony se píší v *latte* (šablonovací systém podobný např. *smarty*), který za vás zajistí bezpečnost znaků na výstupu
            * pokud využijete třídu Nette\Object, je podporováno využívání properties á la c#
            * nezáleží na přesném umístění tříd v souborech, autoload najde všechny třídy, které umístíte do adresáře s aplikací
    * v rámci ukázkových aplikací *záměrně využíváme pro práci s databází jen PDO*
        * už ho známe a umíme s ním pracovat
        * pokud byste chtěli něco s většími možnostmi, tak v Nette je vlastní databázová vrstva, případně se dá používat nějaká vrstva pro objektově-relační mapování (asi nejznámnější je *Doctrine*, či lze využít např. jednoduchý *LeanMapper*)