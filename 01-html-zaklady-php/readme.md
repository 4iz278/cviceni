# 1. HTML, základy PHP syntaxe

* HTML - stručné opakování
* základy syntaxe
* nahrání stránek na výukový server

## PHP
* interpretovaný programovací jazyk spouštěný na straně serveru
* aktuálně obvykle využívána řada 5.x
  * od prosince 2015 je k dispozici také verze 7
  * jednotlivé verze se řeší ve funkcionalitě, některé zastaralé funkce jsou postupně odstraňovány
* PHP soubory mají obvykle příponu **.php**
* nejčastěji je PHP využíváno ke generování textových výstupů (HTML, XML, JSON, plain text atp.), ale je možné generovat také jakýkoliv jiný obsah (PDF, obrázky), či mít skript, který na výstup nevrací nic
* obvykle spouštěno přes webový server (typicky Apache)
  * vytvořený soubor nahrajeme na server a načteme přes prohlížeč
  * pro výuku budeme využívat server [eso.vse.cz](http://eso.vse.cz) - viz [info k přístupům](../00-zakladni-info/server-eso.md)
* v řadě syntaxe PHP podobná Javě
  * podobné
    * stejné zápisy komentářů
    * každý příkaz končí středníkem
    * podobné zápisy cyklů atp.
  * rozdílné
    * volitelné využívání objektů
    * netypovost proměnných
    * nemožnost vícenásobných definic stejných funkcí s různými atributy
    * magické funkce

### Vložení PHP do webových stránek
```php
<?php
  // vlastní kód
?>
```
* PHP bloků může být v kódu libovolné množství
  * všechny PHP bloky na sebe navazují
  * před odesláním obsahu jsou z kódu stránek všechny PHP bloky "odstraněny" (klient je nevidí)
* existují i zkrácené zápisy - pokud možno se jejich využívání vyhněte
* Ukázky:
  * [Hello world! - textový](./hello-text.php)
  * [Hello world! - HTML stránka](./hello-html.php)

### Základní syntaktické konstrukce
#### Komentáře
#### Proměnné
* všechny proměnné jde poznat podle znaku **$**, kterým začíná jejich název
* proměnné není nutné deklarovat, prostě rovnou přiřadíme do dané proměnné hodnotu
* **názvy proměnných**
  * v názvu se smí vyskytovat pouze písmena, číslice a podtržítka
  * PHP rozlišuje velikost písmen v názvu proměnné
  * název musí začínat písmenem či podtržítkem
  * obvykle využíváme velbloudí nebo podtržítkovou notaci
* PHP používá **automatické přetypovávání čísel a řetězců**
* **pozor na boolean hodnoty**
  * jako *false* jsou vyhodnoceny proměnné s hodnotou *false*, *null*, 0, *""* (prázdný řetězec)
  * všechny ostatní hodnoty jsou při přetypování na boolean vyhodnoceny jako *true*
```php
  $a = 10;
  $b = '1';
  echo $a + $b;
```
* pozor, PHP hledá proměnné v kódu a řetězcích
  * zápis **$$a** bude vyhodnocen tím způsobem, že PHP nejprve nahradí *$a* textovou hodnotou dané proměnné (např. *"b"*) a poté bude pracovat s výslednou proměnnou (např. *$b*)
  * název funkce může být uložen také v proměnné - např. **$a()** spustí funkci, jejíž název je uložen v proměnné *$a*

#### Textové řetězce
* řetězce zapisujeme v jednoduchých či dvojitých uvozovkách
  * ve dvojitých uvozovkách jsou vyhledávány
    * proměnné => jsou nahrazeny svojí textovou hodnotou
    * řídící znaky - např. **\n**, **\r**, **\t**
  * řetězec v jednoduchých uvozovkách je prostě řetězcem, PHP v něm nehledá nic jiného vyjma zpětných lomítek a dalších jednoduchých uvozovek
  * uvozovky jsou backslashovat
```php
  echo "The \"best\" paper is $paperName";
```

#### Operátory
*

#### Podmínky
*

#### Cykly
##### Cyklus s podmínkou na začátku (while)
* asi nejčastěji využívaný
```php
while(podmínka){
  //příkazy v cyklu
}
```

##### Cyklus s podmínkou na konci (do-while)

##### Cyklus s daným počtem opakování (for)

##### Cyklus pro procházení polí a kolekcí (foreach)
* bude vysvětlen společně s problematikou polí

##### Řídící příkazy cyklu


#### Funkce


#### Konstanty
* využíváme pro globální označení konkrétní hodnoty, které jsou využívány na více místech kódu
* pro definici vlastních konstant využíváme funkci **define**
  * volitelně nemusí být názvy konstant case sensitive
```php
define("KONSTANTA", "hodnota");
define("KONSTANTA2", "hodnota", true);//konstanta bez rozlišení velikosti písmen v názvu
```
* v PHP je k dispozici řada předdefinovaných konstant
  * např. **__DIR__**, **PHP_VERSION**, **__FILE__** atd.
  * [PHP manuál - konstanty](http://php.net/manual/en/reserved.constants.php)
  * [PHP manuál - magické konstanty](http://php.net/manual/en/language.constants.predefined.php)
