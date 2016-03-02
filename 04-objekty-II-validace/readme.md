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
* **__sleep()**
* **__wakeup()**

###
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
TODO

## Praktická aplikace
TODO
