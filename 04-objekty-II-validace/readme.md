# 4. Objekty v PHP II., validace formulářů

## Magické metody objektů
* **to, že v rámci daného objektu daná vlastnost (proměnná, funkce) neexistuje, ještě neznamená, že s ní nejde praxovat**
* "magické funkce" poznáte podle toho, že začínají na *__* (dvě podtržítka)
* některé z nich už známe - **__construct**, **__destruct**, **__toString**

### Přístup k neexistujícím/nepřístupným proměnným
* v případě, kdy se snažíme pracovat s nějakou neexistující či nepřístupnou proměnnou, PHP místo vyhození chyby nejprve zkusí zavolat funkci, která může "podstrčit" příslušný obsah
* často jsou využívané např. pro dynamicky načítané objekty (XML struktura atp.), objektově-relační mapování atp.
* některé frameworky pomocí nich simulují klasické "properties" á la c# (private proměnná s get() a set())
* **__get(jmenoPromenne)**
  * funkce zavolaná v situaci, kdy chceme načíst neexistující či nepřístupné proměnné
* **__set(jmenoPromenne, prirazovanaHodnota)**
  * funkce zavolaná v situaci, kdy chceme přiřadit obsah do neexistující či nepřístupné proměnné
* **__isset(jmenoPromenne)**
  * funkce zavolaná v situaci, kdy zavoláme *isset()* nebo *empty()* na neexistující či nepřístupné proměnné
* **__unset(jmenoPromenne)**
  * funkce zavolaná v situaci, kdy zavoláme *unset()* na neexistující či nepřístupné proměnné

* drobné upozornění - PHP brání rekurzivnímu zacyklení v rámci magických metod - tj. pokud v rámci __get zkusíme přistupovat k neexistující proměnné, nedojde k rekurzivnímu volání (je možné ho vynutit jen ručním zavoláním __get())

* [příklad neexistující proměnné](./04-magicke-promenne.php)
* [příklad simulace properties](./04-magicke-getset.php)

### Přístup k nedefinovaným/nepřístupným metodám
* **__call(jmenoMetody, argumenty)**
  * funkce volaná v případě volání neexistující metody
* **__callStatic(jmenoMetody, argumenty)**
  * funkce volaná v případě volání neexistující statické metody, podpora v PHP 5.3+

* [příklad neexistující metody](./04-magicke-metody.php)

### Serializace a "uspávání" objektů
* **Co to je serializace?**
* aktuálně máme v PHP na výběr 2 varianty podpory serializace v rámci definice třídy
  * třída bude implementovat rozhsaní **Serializable** (poskytuje víc variability)
  * implementovat magické metody **__sleep()** a **__wakeup()** (jednodušší)
* z hlediska následného využití je to vlastně jedno :)

* [příklad sleep-wake up](./04-sleep-wakeup.php)
* [příklad Serializable - jednoduché pole](./04-serializable-v2.php)
* [příklad Serializable - asociační pole](./04-serializable.php)

* až se budeme bavit o formátu JSON ([10. cvičení](./10-json-xml)), vzpomeňte si ještě na podobné rozhraní - *JsonSerializable*

### Další magické funkce
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

* [příklad clone](./04-magicke-clone.php)
* [příklad toString](./04-magicke-toString.php)
* [příklad invoke](./04-magicke-invoke.php)
* [PHP manuál - Magické metody](http://php.net/manual/en/language.oop5.magic.php)


## Automatické načítání tříd
### Class loader
* rozčleňování kódu do většího množství souborů (obvykle v podstatě každá třída zvlášť) přispívá k jednodušší orientaci ve zdrojácích
* pro vykonání kódu potřebujeme ale všechen kód "na jednom místě"
* načítání souborů pomocí *require_once* je pruda :/ (a vede k chybám v případě, že na něco zapomeneme)

```php
spl_autoload_register(function($name){
  //vyřešení jména souboru a jeho require
});
```
* autoload funkcí je možné zaregistrovat i větší množství, volají se postupně, jak byly zaregistrovány do fronty (dokud některá z nich nevrátí true)
  * pole zaregistrovaných funkcí je možné získat pomocí *spl_autoload_functions()*, zvolenou funkci je možné odstranit pomocí *spl_autoload_unregister()*

* [příklad autoload](./04-autoload)
* [příklad autoload funkce pracující se jmennými prostory](./04-autoload-namespaces.php)

### Načítání tříd při použítí frameworku
* v podstatě všechny PHP frameworky zahrnuje nějakou vlastní podobu autoloadu => **při použití frameworku neimplementujeme vlastní autoload**
* často je očekáváno rozdělení souborů do pevně daných adresářů (*controllers*, *model* atp.), nebo načítání podle jmenných prostorů
* zajímavou metodu implementuje např. Nette - naindexuje všechny třídy v zadaném adresáři (bez ohledu na jejich umístění v podadresářích)

### Composer
* pokud chceme pracovat s externími "knihovnami" (balíčky tříd), je v PHP obvyklé neskládat dané kódy ručně, ale spracovat závislosti projektu pomocí composeru
* **composer = správce závislostí pro PHP projekty**
  * viz http://getcomposer.com
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
