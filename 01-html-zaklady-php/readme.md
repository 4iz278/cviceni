# 1. HTML, základy PHP syntaxe

## HTML
* **předpokládáme, že už všichni umíte napsat aspoň jednoduchou HTML stránku...**
  * pokud budete hledat podklady k HTML či CSS, mrkněte na [podklady k předmětu 4iz268](https://github.com/4iz268/cviceni)

### Opakování základů HTML a CSS
* TODO


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
  * [Hello world! - textový](./01-hello-text.php)
  * [Hello world! - HTML stránka](./01-hello-html.php)
* pokud chcete jen vypsat hodnotu proměnné, je možné využít také zkrácený zápis
```php
<?=$promenna?>
```

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
    * proměnné => jsou nahrazeny svojí textovou hodnotou (volitelně je lze oddělit od okolního textu složenými závorkami)
    * řídící znaky - např. **\n**, **\r**, **\t**
  * řetězec v jednoduchých uvozovkách je prostě řetězcem, PHP v něm nehledá nic jiného vyjma zpětných lomítek a dalších jednoduchých uvozovek
  * uvozovky jdou backslashovat
  * pro speciální případy lze využít NOWDOC (HEREDOC) syntaxi
* [příklad řetězce](./01-retezce.php)
```php
  echo "The \"best\" paper is $paperName";
```

#### Operátory
##### Základní operátory
TODO

##### Logické operátory
TODO

#### Podmínky
##### Jednoduchá podmínka
```php
if (podminka){
  //true větev
}else{
  //false větev; volitelně ji lze vynechat
}
```
* pokud má být v dané větvi vykonán jen jeden příkaz, není nutné ho balit do složených závorek

##### Vícenásobná podmínka
```php
if (podminka1){
  //větev při spojení podmínky 1
}elseif (podminka2){
   //větev při spojení podmínky 2;
}else{
  //při nesplnění žádné předchozí větve
}
```
* elseif větví může být zapojeno libovolné množství

##### Zkrácená podmínka při přiřazení
* ve výpisech, zapojení příslušné části řetězce atp.
```php
// proměnná = podminka ? true větev : false větev;

$x = ( $a=="tykani" ? "Ahoj" : "Dobrý den" );
```
* [příklad podmínky](./01-podminky.php)

#### Cykly
##### Cyklus s podmínkou na začátku (while)
* asi nejčastěji využívaný
* nepoužívejte cykly, které mají na začátku v podmínce napsané jen *true*!!!
```php
while(podmínka){
  //příkazy v cyklu
}
```

##### Cyklus s podmínkou na konci (do-while)
* proběhne alespoň jednou
```php
do{
  //příkazy v cyklu
}while(podmínka);
```

##### Cyklus s daným počtem opakování (for)
```php
for (inicializace iterátoru; podmínka; úprava hodnoty iterátoru){
  //příkazy cyklu
}

for($x=1; $x>=10; $x-=2){
  //příkazy cyklu
}
```
* [příklad cykly](./01-cykly.php)

##### Cyklus pro procházení polí a kolekcí (foreach)
* pro zpracování všech prvků v poli či kolekci
* bude [vysvětlen společně s problematikou polí](../02-retezce-soubory#foreach-cyklus)

##### Řídící příkazy cyklu
* **break;** - ukončí cyklus a pokračuje v kódu za ním
* **continue;** - ukončí aktuální průchod cyklem a přejde na podmínku
```php
for($x=0;$x<10;$x++){
  if (podminka){
    continue;
  }
  //další příkazy
}
```

#### Switch
* pro výběr z více variant kódu dle hodnoty jedné proměnné
* kód je vykonáván od příslušné shody podmínky a pokračuje až do příkazu *break;* (nebo prostě dál...)
```php
switch ($promenna){
    case "A":
      /*blok kódu*/
      break;
    case "B":
      /*blok kódu*/
    default:
      /*blok kódu*/
}
```
* [příklad switch](./01-switch.php)

#### Funkce
* pro pojmenování funkcí platí stejné podmínky, jako pro názvy proměnných (jen *nezačínají znakem $*)
* funkce nemusejí být zabaleny v žádných třídách
* u funkcí je podporována typová kontrola parametrů, pokud jimi mají být instance tříd
* funkce mohou mít také volitelné parametry, které mají rovnou přiřazenou nějakou hodnotu
```php
  function mojeFunkce($a, $b="x"){
    echo 'hodnota A byla '.$a.', hodnota B byla '.$b;
  }
```
* návratová hodnota se vrací pomocí příkazu **return**
* parametry funkcí jsou jen vstupní, pokud před jejich název nepřidáme znak **&** - pak je předávána reference místo hodnoty a danou proměnnou lze přepsat z těla funkce
* [příklady definice funkcí](./01-funkce.php)


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
* v nových verzích PHP lze využívat také zjednodušenou definici
```php
const KONSTANTA = "hodnota";
```
* [příklady použití konstant](./01-konstanty.php)

#### GOTO
* příkaz *goto* umožňuje přeskočit na libovolné místo v kódu, které jsme předem označili návěštím
* v PHP od verze 5.3, ale doporučuji nepoužívat
  * výrazně porušuje pravidla zapouzdření objektů (a dnes píšeme většinu aplikací objektově)
  * znepřehledňuje kód
  * jako identifikaci návěští, kam chceme pokračovat, stejně nejde definovat v proměnné...
```php
navesti:
  //nějaké příkazy

if (podminka){
  goto navesti;
}
```


### Alternativní PHP syntaxe
* vedle aktuálně využívané "závorkové" syntaxe lze v rámci PHP využívat také syntaxi převzatou z basicu
* obě syntaxe je možné volně kombinovat
* [PHP manuál - alternativní syntaxe](http://php.net/manual/en/control-structures.alternative-syntax.php)
```php
if ($podminka):
  //true větev
else:
  //else větev
endif;

for ($x=0; $x<=5; $x++):
  //příkazy cyklu
endfor;
```
