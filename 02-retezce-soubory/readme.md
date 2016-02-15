# 2. Řetězce, soubory

## Pole
* pole = v podstatě "tabulka hodnot", ve které jsou jednotlivé buňky označeny buď čísly, nebo názvy
  * číselné indexování začíná *0*
* s ohledem na práci s datovými typy v PHP může každá buňka obsahovat něco jiného
* vícedimenzionální (vícenásobné) pole = pole, ve kterém je v každé buňce uloženo další pole

### Definice nového pole
* funkce *array()*
* v nových verzích PHP je možné využívat definici pomocí *[]*
```php
  $pole1 = array();//vytvoří prázdné pole
  $pole2 = []; //vytvoří prázdné pole (zkrácená syntaxe)
  $pole3 = array("a","b","c");//vytvoří pole s hodnotami "a", "b" a "c", uloženými pod číselnými indexy
  $pole4 = array(10=>"a");//vytvoří pole, pod index 10 uloží hodnotu "a"
```

### Přidání a odebrání prvku
```php
  $pole[]=$hodnota; //přidá prvek na konec indexovaného pole
  $pole[10]=$hodnota; //přidá prvek pod konkrétní číselný index
  $pole["klic"]=$hodnota; //přidá prvek pod konkrétní řetězcový index

  unset($pole["klic"]); //smaže konkrétní prvek z pole
```
* s prvky jde pracovat také pomocí funkcí
  * **array_pop($pole)**
    * odebere poslední prvek z pole, vrací jeho hodnotu
  * **array_push($pole, $hodnota)**
    * přidá prvek na konec pole
  * **array_shift($pole)**
    * odebere první prvek z pole, vrací jeho hodnotu
  * **array_unshift($pole, $hodnota)**
    * přidá prvek na začátek pole

### Funkce pro práci s poli
* **count($pole)**
  * vrací počet prvků v poli

* **array_kez_exists($klic, $pole)**
  * funkce pro kontrolu, jestli je v poli daný klíč

* **array_merge($pole, $pole2)**
  * funkce pro sloučení dvou polí

* **sort($pole)**
  * funkce pro seřazení indexovaného pole podle hodnot

* **uasort()**
  * funkce pro seřazení indexovaného pole pomocí uživatelem definované funkce
  * viz [w3schools](http://www.w3schools.com/php/func_array_uasort.asp)

* **uksort()**
  * funkce pro seřazení asociačního pole pomocí uživatelem definované funkce
  * viz [w3schools](http://www.w3schools.com/php/func_array_uksort.asp)

* [w3schools - Array functions](http://www.w3schools.com/php/php_ref_array.asp)

### Foreach cyklus
* cyklus umožňující projití všech prvků v poli (či kolekci)
```php
foreach($pole as $hodnota){
  //zpracování jednotlivých položek
  echo $hodnota;
}

foreach($pole as $klic => $hodnota){
  //zpracování jednotlivých položek (máme k dispozici i klíče)
}
```
* pokud chceme mít možnost zapisovat do daných proměnných, musíme před ně doplnit *&* (aby byly do cyklu předány jako reference)
```php
foreach($pole as &$hodnota){
  $hodnota = "xxx";//pokud byla proměnná předána referencí, půjde do ní zapisovat
}
```
* nepoužívejte ve foreach cyklu unset na prvek pole

## GET, POST, REQUEST
* pokud nemá stránka jen něco vypisovat, ve většině případů potřebujeme pracovat se vstupními daty
* zkusíme trochu zavzpomínat na "sítě"
  * *Jaký je rozdíl mezi metodami GET a POST?*
  * *základní struktura URL adres*
```
http://subdomena.domena.tld/adresar/skript.php?parametr=hodnota&parametr2=hodnota#kotva
```
* v PHP máme k dispozici globální proměnné **$_GET**, **$_POST** a **$_REQUEST**
  * jedná se o pole, ve kterých máme připravený uživatelský vstup
* [příklad GET](./get.php)

## Řetězcové funkce
* **strlen($retezec)**
  * funkce vracející počet znaků aktuálního řetězce

* **trim** - funkce pro odstranění znaků ze začátku a konce řetězce
  * ve výchozím stavu odstraňuje "prázdné" znaky, ale lze zadat, co se má odstranit
  * existují také funkce **ltrim** a **rtrim**
```php
$str  = trim($str); //odstraní prázdné znaky z konců řetězce
$str2 = trim($str,"\n\r\t ;x"); //odstraní nové řádky,tabulátory, mezery, středníky a písmeno x
$str3 = trim($binary, "\x00..\x1F"); //odstraní znaky s binárním kódem 0-31 (včetně)
```

* **strpos($haystack, $needle [,$offset])**
  * funkce pro zjištění pozice podřetězce v řetězci
  * parametr *$offset* je jen volitelný
  * pozor, ve výsledku je nutné rozlišovat hodnoty *0* a *false* (použijte operátor  ===, event. !==)
  * *zkuste si tuto funkci najít v PHP manuálu...*

* **substr($string, $start[, $length])**
  * vrací část řetězce
  * parametr *$length* je jen volitelný (pokud není uveden, je vrácen celý zbytek řetězce)
```php
$cast = substr("Lorem ipsum...",5);
```

* **str_replace($search, $replace, $subject[, $count])**
  * umí nahradit zadaný řetězec jiným řetězcem
  * pokud zadáme jako parametry pole, umí provést víc nahrazení najednou
  * pokud je zadána proměnná do parametru *$count*, je do ní uložen počet provedených nahrazení
```php
echo str_replace("jmeno", "Pepo", "Ahoj jmeno");
echo str_replace(['ipsum','dolor'], ['A','B'], "Lorem ipsum dolor sit amet, consectetuer adipiscing elit...");
```

* **strtolower($retezec)**, **strtoupper($retezec)**, **ucfirst($retezec)**, **ucwords($retezec)**
  * funkce pro změnu velikosti znaků (pozor, vyzkoušejte, jestli na daném serveru fungují korektně s českými znaky)

* **strip_tags($retezec[, $povoleneTagy])**
  * funkce pro odstranění HTML značek
  * volitelně je možné některé značky povolit
```php
$upravene = strip_tags($retezec,'<em><strong>');
```

* **htmlspecialchars($retezec)**
  * funkce pro nahrazení speciálních znaků HTML entitami
  * jedná se o často využívanou funkci - měli bychom ji aplikovat na data, která byla získána od uživatele a vypisujeme je na výstup!
```php
echo '<input type="text" name="x1" value="'.htmlspecialchars($_REQUEST['x1']).'">;
```

* **addslashes($retezec)**, **stripslashes($retezec)**
  * funkce pro přidání/odebrání zpětných lomítek u znaků *'*, *"* a *\\*
  * *DÚ: Proč bychom neměli na serveru zapínat direktivu "MAGIC_QUOTES_GPC"?*

* **explode($oddelovac, $retezec, $limit)**
  * funkce pro rozdělení řetězce do pole (podle zadaného oddělovače)
  * parametr *$limit* je volitelný, určuje maximální počet částí, na které bude řetězec rozdělen

* **implode($spojovac, $pole)**
  * spojí prvky z pole do řetězce
  * funkce má alias **join($spojovac, $pole)**

* **strrev($retezec)**
  * obrátí pořadí znaků v řetězci

* **nl2br($retezec)**
  * nahradí konce řádků html značkou *<br>*

* **str_word_count($retezec)**
  * vrací počet slov v řetězci

* **urlencode($retezec)**, **urldecode($retezec)**, **rawurlencode($retezec)**, **rawurldecode($retezec)**
  * funkce pro zakódování/dekódování URL adres (jak jistě víte, některé znaky se v nich vyskytovat nemohou...)

* **iconv**
  * funkce pro změnu kódování řetězce
```php
echo iconv("UTF-8", "ISO-8859-2//TRANSLIT", "10 €"); //vypíše 10 EUR
echo iconv("UTF-8", "ISO-8859-2//IGNORE", "10 €"); //vypíše 10
```

### mb_ funkce
TODO

## Práce se soubory
* PHP podporuje velké množství funkcí pro práci se soubory
* pokud je povolený *fopen wrapper*, je možné pracovat se vzdálenými soubory obdobně, jako by šlo o soubory lokální
* pozor na přístupová práva k souborům
  * pokud chceme zapisovat do souboru/adresáře, je nutné na většině hostingů upravit dané položce přístupová práva

### Include, require
* PHP nevyžaduje rozdělení aplikace do jednotlivých souborů - i při objektové aplikaci můžeme vše napsat jen do jednoho souboru, ale...
* pokud se máme v aplikaci vyznat, je vhodné ji rozčlenit na logické celky uložené v samostatných souborech
* příkazy *include* a *require* jsou jedním z nejjednodušších využití PHP také na statických stránkách - pro oddělení hlavičky a patičky do samostatného souboru
* *include* a *require* mohou být v kódu zapsány jak v podobě funkce, tak také v podobě příkazu (tj. bez závorek)
* vkládané soubory by měly mít příponu PHP (aby nebylo možné stáhnout jejich zdroják pomocí prohlížeče)
  * v případě neobjektové aplikace je vhodné vkládané soubory oddělit do samostatného adresáře, nebo jim např. dopsat do názvu *"inc"* => na první pohled je pak
* *Jaký je rozdíl mezi "include" a "require"?*
```php
include "connection.inc.php";
require "connection.inc.php";
include_once "connection.inc.php"; //funkce s "_once" načtou soubor jen v tom případě, že dosud nebyl načten
require_once "connection.inc.php";
```
* [příklad include](./include/index.php)

### Načtení/uložení celého souboru
* celý obsah souboru je možné načíst či uložit pomocí jednoho zavolání funkce

#### file_get_contents
* načte celý soubor
* viz [w3schools - PHP file_get_contents() Function](http://www.w3schools.com/php/func_filesystem_file_get_contents.asp)
  * k čemu jsou dobré další atributy dané funkce?
```php
$soubor = file_get_contents('soubor.txt');
```
#### file_put_contents
* uloží celý soubor
* pomocí 3. parametru je možné zapisovat až na konec
* vhodné pro jednorázový zápis (např. poznámka logu, kde nechceme udržovat odkaz na otevřený soubor)
```php
file_put_contents('soubor.txt',$data,FILE_APPEND);//připojení obsahu na konec souboru
```

#### readfile
* funkce pro odeslání obsahu souboru na výstup (např. pro zabezpečené stahování PHP souborů)
  * pokud chceme korektně nabídnout soubor ke stažení, je nutné doplnit odpovídající hlavičky pomocí funkce *header()*
```php
readfile("soubor.txt");
```
* [příklad readfile](./readfile/index.php)

### Soubory - čtení, zápis
TODO

## Příklad na procvičení
TODO