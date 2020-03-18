# 4. Objekty v PHP II., validace formulářů

:grey_exclamation: **Tato složka obsahuje podklady k domácímu studiu ke cvičením 19. a 20.3.2020.**
Oproti běžným podkladům ke cvičením zde naleznete podrobnější vysvětlení dané problematiky a další příklady.

## Opakování z minulého cvičení

:point_right:

V [minulém cvičení](../03-objekty/) jsme dokončili problematiku práce se soubory, bavili jsme se o chybách a výjimkách a začali se zabývat prací s objekty.


:point_right:

Z hlediska stručného **opakování práce se soubory**: 
- při práci se soubory lze pracovat buď se souborem jako celkem (include, file_get_contents, file_put_contents, readfile),
- nebo jde pracovat s file streamem (soubor je vlastně řetězec dat, který můžeme otevřít a následně se v něm pohybovat a měnit ho).
    - nejprve soubor otevřeme pomocí funkce fopen (a vybíráme si, zda chceme soubor číst, nebo do něj zapisovat)
    - následně můžeme číst pomocí fgets nebo fread (podle toho, zda chceme číst po řádcích, nebo po bytech)
    - pro zápis používáme fwrite nebo fputs
    - pohybovat se jde pomocí fseek, feof pak zjistí, jestli jsme na konci file streamu
    - soubor bychom neměli zapomenout zavřít pomocí fclose.


:point_right:

Z hlediska **opakování chyb a výjimek**:
- výjimky se chovají vlastně stejně, jako např. v javě
    - výjimka je instance třídy Exception, pro odchycení používáme try-catch blok
    - oproti javě nás PHP nenutí všechny výjimky odchytit na úrovni kódu, když je nezachytíme, zobrazí se uživateli
- chyby jsou vyhazovány nejčastěji některými vestavěnými funkcemi (include, fopen), při přístupu k nedefinovaným proměnným atp.
    - máme různé úrovně chyb, které jsou buď odchytitelné univerzální funkcí (např. pro zápis do logu),
    - nebo chyby nejčastěji skrýváme pomocí zavináče uvedeného před názvem proměnné či před názvem funkce.


:point_right:

Následně jsme se zabývali také **základními vlastnostmi objektů**. Z toho byste si měli pamatovat:
- definice tříd se chovají podobně jako v javě, ale používáme některé specifické operátory:
    - :: (dvě dvojtečky) jsou odkazem na statickou proměnnou nebo na statickou metodu (např. ```MojeTrida::metoda();``` nebo ```MojeTrida::$promenna = 1;```)
    - -> (šipka) odděluje instanci od její metody či její proměnné - u té ale pak nepíšeme znak $ (např. ```$objekt->mojeMetoda();``` nebo ```$objekt->cislo = 1;```)
- konstruktor se jmenuje ```__construct```  
- nemůžeme definovat jednu metodu víckrát s různými parametry, ale můžeme mít u metody parametry volitelné
- funguje tu normální dědičnost pomocí ```extends``` a implementace rozhraní pomocí ```implements```
    - ve výchozím stavu třídy od ničeho nedědí, rozhodně ne od nějaké obecné třídy *Object*    
- PHP podporuje i vícenásobnou dědičnost pomocí *traitů*
    - jde vlastně o kousek třídy, který chceme použít na víc místech
    - definujeme ho jako třídu, ale s klíčovým slovem ```trait```, tj. například ```trait MujTrait { /*obsah traitu*/ }```
    - tam, kde ho chceme použít, napíšeme něco jako ```class Trida1 { use MujTrait; /*tělo třídy*/ }``` - chová se to pak stejně, jako kdybychom daný kód z traitu na to místo nakopírovali.


:point_right:

V PHP se běžně používají také **jmenné prostory**:
- definujeme je pomocí zápisu ```namespace JmennyProstor;``` 
- vztahují se nejen na objekty, ale také na funkce definované volně v kódu
- pro oddělování jmenných prostorů od používáme zpětné lomítko
- pro import třídy z jiného namespace použijeme zápis ```use JmennyProstor\MojeTrida;``` (mimo definici třídy, ve třídě se *use* používá pro načtení traitu).    
    
---     

:point_right:

**Na tomto cvičení nás čekají 2 hlavní témata:**
- **[dokončení problematiky objektů](#magick%C3%A9-metody-objekt%C5%AF)**
- **[validace formulářů](#validace-formul%C3%A1%C5%99%C5%AF)**

---

## Magické metody objektů
:point_right: 

**To, že v rámci daného objektu daná vlastnost (proměnná, funkce) neexistuje, ještě neznamená, že s ní nejde pracovat.** Magické metody nám umí např. nasimulovat proměnné načítané dynamicky z databáze atp.  
- Všechny "magické metody" poznáte podle toho, že začínají na **__** (dvě podtržítka)
- Mezi magické metody patří také 3, které už vlastně znáte:
    - **__construct** - vytváří instanci objektu - používali jsme ho na minulém cvičení,
    - **__desctruct** - pro "uklizení" po objektu (např. odpojení se od databáze atp.) při ukončení jeho existence,
    - **__toString** - metoda automaticky volaná při přetypování objektu na string.
    
:point_right:

V následujících odstavcích jsou uvedeny jednotlivé magické metody s příklady - zkuste si je prosím projít, případně zkusit spustit.     


:point_right:

### Přístup k neexistujícím/nepřístupným proměnným
- V případě, kdy se snažíme pracovat s nějakou neexistující či nepřístupnou proměnnou, PHP místo vyhození chyby nejprve zkusí zavolat funkci, která může "podstrčit" příslušný obsah.
    - Pokud umí magická metoda pracovat s proměnnou s daným jménem, tak se to pro vnější kód tváří tak, jako kdyby v daném objektu ta proměnná opravdu byla.  
    - Často jsou využívané např. pro dynamicky načítané objekty (XML struktura atp.), objektově-relační mapování atp.
    - Některé frameworky pomocí nich simulují klasické "properties" á la c# (private proměnná s get() a set())
- **__get(jmenoPromenne)**
  * funkce zavolaná v situaci, kdy chceme načíst neexistující či nepřístupné proměnné
- **__set(jmenoPromenne, prirazovanaHodnota)**
  * funkce zavolaná v situaci, kdy chceme přiřadit obsah do neexistující či nepřístupné proměnné
- **__isset(jmenoPromenne)**
  * funkce zavolaná v situaci, kdy zavoláme *isset()* nebo *empty()* na neexistující či nepřístupné proměnné
- **__unset(jmenoPromenne)**
  * funkce zavolaná v situaci, kdy zavoláme *unset()* na neexistující či nepřístupné proměnné

:grey_exclamation: Drobné upozornění - PHP brání rekurzivnímu zacyklení v rámci magických metod - tj. pokud v rámci __get zkusíme přistupovat k neexistující proměnné, nedojde k rekurzivnímu volání (je možné ho vynutit jen ručním zavoláním __get())


:blue_book:
* [příklad neexistující proměnné](./04-magicke-promenne.php)
* [příklad simulace properties](./04-magicke-getset.php)


:point_right:

### Přístup k nedefinovaným/nepřístupným metodám
- Obdobně, jako k nedefinovaným či private proměnným, můžeme přistupovat také k nedefinovaným či private metodám. Při zavolání takové metody dojde k zavolání jedné z následujících funkcí, která může vykonat požadovaný kód stejně, jako by daná metoda definována byla.   
- **__call(jmenoMetody, argumenty)**
  * funkce volaná v případě volání neexistující metody
- **__callStatic(jmenoMetody, argumenty)**
  * funkce volaná v případě volání neexistující statické metody


:blue_book:
* [příklad neexistující metody](./04-magicke-metody.php)


:point_right:

### Serializace a "uspávání" objektů
- **Co to je serializace?**
    - Pokud si aspoň matně vzpomínáte na hodiny javy, tak serializace tam sloužila k možnosti přerušení činnosti objektu a jeho uložení do řetězce, který bylo možné např. přenést přes síť či uložit do souboru nebo do databáze.
    - V PHP se to chová obdobně, přičemž musíte říct, co se má vlastně serializovat (které vnitřní proměnné) a následně vznikne řetězec.  
- V rámci PHP serializace jsou uchovány informace o datových typech proměnných, vnitřní struktuře atp. a např. u řetězců či polí je pro ověření zapsána do řetězce i jejich délka.    
- Aktuálně máme v PHP na výběr 2 varianty podpory serializace v rámci definice třídy. Z hlediska následného použití je vlastně jedno, kterou z těchto variant si vyberete :)
    1. třída bude implementovat rozhraní **Serializable** (poskytuje víc variability)
    2. implementovat magické metody **__sleep()** a **__wakeup()** (jednodušší)


:blue_book:
* [příklad sleep-wake up](./04-sleep-wakeup.php)
* [příklad Serializable - jednoduché pole](./04-serializable-v2.php)
* [příklad Serializable - asociační pole](./04-serializable.php)


:point_right:

Až se budeme bavit o formátu JSON ([10. cvičení](./10-json-xml)), vzpomeňte si ještě na podobné rozhraní - *JsonSerializable*.

Pokud budete chtít celé objekty ukládat do databáze a nebudete je chtít rozepisovat do jednotlivých sloupců v tabulce (např. nějakou konfiguraci, kterou budete načítat vždy jako celek), doporučuji z praxe spíš serializovat daný objekt do JSONu, než pomocí PHP serializace. Už kvůli tomu, že JSON načtete i z libovolného jiného jazyka, ale PHP serializaci ne. Zároveň v JSONu nejsou kontrolovány např. délky řetězců - za což budete rádi, až budete chtít některý z nich nahradit jinou hodnotou např. při migraci na jinou doménu.


:point_right:

### Další magické metody
Z dalčích magických metod obvykle definujeme ```__toString()``` a případně ```__clone()```, ostatní se moc často nepoužívají.

* **__clone()**
  * funkce volaná v případě, že chceme vytvořit klon daného objektu (samostatnou kopii)
  * běžně se při přiřazení objekty přiřazují referencí, pokud chceme samostatnou kopii, je nutné objekt naklonovat
  * využívá se pro vytvoření kopií navázaných objektů
* **__toString()**
  * funkce volaná v případě, kdy chceme daný objekt převést na string (např. při výpisu atp.)
* **__invoke()**
  * funkce volaná v případě, kdy se pokusíme zavolat objekt jako funkci
  * daný objekt je potom klasifikován jako *callable*
* **__set_state()**
  * funkce volaná v případě využití funkce *var_export($objekt)*
* **__debugInfo()**
  * funkce volaná v případě využití funkce *var_dump($objekt)*, podpora v PHP 5.6+


:blue_book:
* [příklad clone](./04-magicke-clone.php)
* [příklad toString](./04-magicke-toString.php)
* [příklad invoke](./04-magicke-invoke.php)
* [PHP manuál - Magické metody](http://php.net/manual/en/language.oop5.magic.php)


## Automatické načítání tříd
:point_right:

Je normální psát v PHP objektově! Narozdíl např. od javy v něm ale nejsou žádná striktní pravidla ohledně toho, jak rozmístit kód do jednotlivých souborů.
**Obvykle uvádíme každou třídu, rozhraní či trait v samostatném souboru, přičemž je rozmisťujeme do adresářů buď podle jmenných prostorů, nebo podle jejich logické funkce.**
- Rozčleňování kódu do většího množství souborů (obvykle v podstatě každá třída zvlášť) přispívá k jednodušší orientaci ve zdrojácích
- Pro vykonání kódu potřebujeme ale všechen kód "na jednom místě" a načítání souborů pomocí *require_once* je pruda :/ (a vede k chybám v případě, že na něco zapomeneme). 


:point_right:

### Class loader
V PHP žádný automatický class loader není. Můžeme ale jednoduše definovat funkci, která se zavolá v situaci, kdy chceme pracovat s třídou, kterou jsme zatím nenačetli. A tato funkce nám načte soubor, ve kterém je definice dané třídy uložena.

```php
spl_autoload_register(function($name){
  //vyřešení jména souboru a jeho require - funkce vrací true či false podle toho, zda se jí povedlo danou třídu načíst
});
```

Autoload funkcí je možné zaregistrovat i větší množství, volají se postupně, jak byly zaregistrovány do fronty (dokud některá z nich nevrátí true)
  * pole zaregistrovaných funkcí je možné získat pomocí ```spl_autoload_functions()```, zvolenou funkci je možné odstranit pomocí ```spl_autoload_unregister()```


:blue_book:
* [příklad autoload](./04-autoload)
* [příklad autoload funkce pracující se jmennými prostory](./04-autoload-namespaces)


:point_right:

### Načítání tříd při použítí frameworku
* v podstatě všechny PHP frameworky zahrnuje nějakou vlastní podobu autoloadu => **při použití frameworku neimplementujeme vlastní autoload**
* často je očekáváno rozdělení souborů do pevně daných adresářů (*controllers*, *model* atp.), nebo načítání podle jmenných prostorů
* zajímavou metodu implementuje např. Nette - naindexuje všechny třídy v zadaném adresáři (bez ohledu na jejich umístění v podadresářích)


:point_right:

### Composer
* pokud chceme pracovat s externími "knihovnami" (balíčky tříd), je v PHP obvyklé neskládat dané kódy ručně, ale spracovat závislosti projektu pomocí composeru
* **composer = správce závislostí pro PHP projekty**
  * viz http://getcomposer.org
  * distribuován v podobě PHAR archívu (= ZIP archív s instrukcemi pro spuštění zahrnutých PHP skriptů)
* jako správce balíčků se používá [Packagist](https://packagist.org/), nebo GITové úložiště (nejčastěji GitHub)
* postup použití:
  1. stáhneme/nainstalujeme composer
  2. definujeme soubor **composer.json**
    * v rámci tohoto souboru jsou definovány všechny závislosti
    * alternativně se dá composer kompletně ovládat konzolovými příkazy
  3. necháme composer stáhnout veškeré potřebné balíčky
  4. v rámci aplikace načítáme jen jeden soubor (*autoload.php*), v rámci kterého jsou vygenerovány instrukce pro načítání všech zahrnutých tříd

```json
{
  "name": "4iz278/03-composer-example-project",
  "description": "Ukázkový project",
  "require": {
    "mpdf/mpdf": "v6.0.0"
  }
}
```
```
php composer.phar update
```

* [příklad composer](./04-composer-example-project)

---

## Validace formulářů
* o tom, jak získat data z formulářů, jsme se už bavili - viz [2. cvičení](./02-retezce-soubory) - zatím jsme je ale moc nekontrolovali...

### Základní zásady
* **Všechny vstupy od uživatele je nutné kontrolovat** - ať už byly odeslány formulářem, nebo v URL uvedené v rámci odkazu!
* kontrolovat data můžeme také např. v HTML5 či JavaScriptu, ale přesto je znovu musíme kontrolovat i na serveru!
* chyby musíme uživateli zobrazovat v přehledné a hlavně srozumitelné podobě
  * žádné hlášky ve stylu "Ve formuláři je chyba."
* u důležitějších formulářů je vhodné aplikovat CSRF ochranu (Cross-Site Request Forgery) - ale to až budeme umět používat *session*...


* **pokud odesíláme formulář pomocí POSTu, je nutné po jeho úspěšném zpracování provést redirect!**
  * i v případě, kdy přesměrováváme na ten samý skript

```php
header('Location: skript.php'); //ukázka odeslání hlavičky pro dočasné přesměrování
```

### Postup implementace validace
1. kontrola v rámci HTML/HTML 5 formuláře
   * nedá se na ni sice úplně spolehnout, ale je to nejrychlejší varianta, jak "omezit" kreativitu uživatele
   * např. vhodná formulářá pole (datum, čas), omezení délky atd.
2. volitelná kontrola v JavaScriptu
   * vhodná hlavně u dynamicky načítaných formulářů, jinak není úplně nezbytná
   * může být výrazně interaktivnější, než kontrola na serveru (např. se uživatel dozví o chybě hned při zadání chybné hodnoty)
3. kontrola dat na serveru
   * ať už byla data získána z GETu, nebo POSTu
4. zobrazení formuláře k opravě
   * musí v něm být ty hodnoty, které nám uživatel poslal! (aspoň ty, které byly správně)

### Užitečné validační funkce
* **preg_match($pattern, $text)**
  * funkce pro kontrolu, zda zadaný text odpovídá požadovanému regulárnímu výrazu
* **filter_var($text, $filtr)**
  * funkce pro validaci a případné "pročištění" vstupu (např. e-mailu)


* [příklad validace - HTML 5](./04-validace-html5.php)
* [příklad validace - souhrnné hlášení chyb](./04-validace-souhrnna.php)
* [příklad validace - hlášení chyb u jednotlivých inputů](./04-validace-inputy.php)
* [podklady k formulářům v JavaScriptu](https://github.com/4iz268/cviceni/tree/master/10-formulare)
* [w3schools - Filter functions](http://www.w3schools.com/php/php_ref_filter.asp)
* [PHP manuál - preg_match](http://php.net/manual/en/function.preg-match.php)


## Praktická aplikace
> Vaším úkolem je vytvořit aplikaci pro správu seznamu zaměstnanců, který je uložen v CSV souboru.
> * využijte přiložený soubor [adresar.csv](./04-ukol/adresar.csv)
>   * soubor je v kódování utf-8
> * požadovaná funkcionalita aplikace
>   * načtení položek se záznamy o zaměstnancích s možností jejich seřazení podle jména, bydliště, nadřízeného atp.
>   * zobrazení zaměstnanců formou tabulky
>   * formulář pro úpravu existujícího zaměstnance a přidání zaměstnance nového
>     * povinnými údaji jsou u každého zaměstnance jméno, příjmení, obec, psc
>     * zaměstanec, který je dělníkem, musí mít zadaného nadřízeného (vybraného se selectu, ne zapsaného ručně!)
> * pokud možno napište aplikaci za využití objektů (tj. záznam každého zaměstnance bude instancí objektu)
