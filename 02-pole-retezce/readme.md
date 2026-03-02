# 2. Pole, řetězce, vstup od uživatele

## Pole
* pole = v podstatě "tabulka hodnot", ve které jsou jednotlivé buňky označeny buď čísly, nebo názvy
  * číselné indexování začíná *0*
  * pole s položkami označenými názvy označujeme jako *asociativní*
  * pole si pamatuje pořadí položek bez ohledu na jejich indexy
* s ohledem na práci s datovými typy v PHP může každá buňka obsahovat něco jiného
  * nejjednodušší je dívat se na každou buňku pole jako na samostatnou proměnnou
  * v případě vícedimenzionálního pole jednoduše může být v buňce další vnořené pole
* vícedimenzionální (vícenásobné) pole = pole, ve kterém je v každé buňce uloženo další pole

### Definice nového pole
* funkce *array()*
* v nových verzích PHP je možné využívat definici pomocí *[]*
```php
  $pole1 = array();//vytvoří prázdné pole
  $pole2 = []; //vytvoří prázdné pole (zkrácená syntaxe)
  $pole3 = array("a", "b", "c");//vytvoří pole s hodnotami "a", "b" a "c", uloženými pod číselnými indexy
  $pole4 = array(10=>"a");//vytvoří pole, pod index 10 uloží hodnotu "a"
```

### Přidání a odebrání prvku
```php
  $pole[]=$hodnota; //přidá prvek na konec indexovaného pole
  $pole[10]=$hodnota; //přidá prvek pod konkrétní číselný index
  $pole["klic"]=$hodnota; //přidá prvek pod konkrétní řetězcový index

  echo $pole["klic"]; //vypsání prvku z pole

  unset($pole["klic"]); //smaže konkrétní prvek z pole

  $pole2 = ["a", "b", "c", "d", "e"];
  unset($pole2[1]); // smaže 2. prvek z pole, ale ostatní indexy nezmění - velikost bude 4, ale indexy 0, 2, 3, 4
  var_dump($pole2);
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

* **array_key_exists($klic, $pole)**
  * funkce pro kontrolu, jestli je v poli daný klíč

* **in_array($hodnota, $pole)**
  * funkce pro kontrolu, zda pole obsahuje danou hodnotu (jednodušší, než to hledat cyklem)

* **array_merge($pole, $pole2)**
  * funkce pro sloučení dvou polí
  * u číslovaných polí se položky přečíslují
  * u asociativních polí se stejně označené položky přepíšou
  * alternativně lze sloučit pomocí **+**, ale v tomto případě se nepřepisují hodnoty a nemění se číselné indexy
```php
$pole1 = [
  "a" => 1,
  "b" => 2
];

$pole2 = [
  "b" => 20,
  "c" => 3
];

$sloucene = array_merge($pole1, $pole2); //buňka b je z 2. pole
$doplnene = $pole1 + $pole2; //buňka b je z 1. pole
```

* **sort($pole)**
  * funkce pro seřazení indexovaného pole podle hodnot

* **usort()**
  * funkce pro seřazení indexovaného pole pomocí uživatelem definované funkce (porovnává hodnoty, upraví indexy)
  * viz [w3schools](http://www.w3schools.com/php/func_array_uasort.asp)

* **uasort()**
  * funkce pro seřazení asociačního pole pomocí uživatelem definované funkce (porovnává hodnoty)
  * viz [w3schools](http://www.w3schools.com/php/func_array_uasort.asp)

* **uksort()**
  * funkce pro seřazení asociačního pole pomocí uživatelem definované funkce (porovnává klíče)
  * viz [w3schools](http://www.w3schools.com/php/func_array_uksort.asp)

* existují i další užitečné funkce, ale zatím se bez nich obejdeme - např. **array_filter()**, **array_reduce()** či **array_map()**

* [příklad array](./02-array.php)
* [příklad array-uasort](./02-array-uasort.php)
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
* nepoužívejte ve foreach cyklu *unset* na prvek pole
* [příklad foreach](./02-foreach.php)

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
  * **$_REQUEST** používáme jen v případě, že nám opravdu nezáleží na metodě předání dat (např. u vyhledávání)
  * běžně bereme data z **$_GET** a **$_POST**
* data získáváme od uživatelů nejčastěji z URL adres a pomocí formulářů
  * pokud nevíte jak napsat formulář, zkuste mrknout na [podklady z 4iz268](https://github.com/4iz268/cviceni/tree/master/10-formulare)

* [příklad GET request](./02-get.php)
* [příklad formulář s metodou POST](./02-formular-post.php)
* [opakování z 4iz268 - Základní formulářové prvky](https://github.com/4iz268/cviceni/blob/master/10-formulare/10-form-prvky.html)
* [opakování z 4iz268 - Nové formulářové prvky v HTML 5](https://github.com/4iz268/cviceni/blob/master/10-formulare/10-form-nove-prvky-html5.html)

## Řetězcové funkce
* **strlen($retezec)**
  * funkce vracející počet bajtů aktuálního řetězce
  * u kódování UTF-8 používáme **mb_strlen()** (více u [mb_funkcí](#mb_-funkce))

* **trim($retezec)** - funkce pro odstranění znaků ze začátku a konce řetězce
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

* **str_contains($haystack, $needle)**
  * funkce pro zjištění, zda řetězec obsahuje jiný řetězec
  * často jednodušší než **strpos()** (pokud nepotřebujeme zjistit přesné místo výskytu)

* **str_starts_with($haystack, $needle)**, **str_ends_with($haystack, $needle)** 
  * zjištění, zda řetězec začíná/končí zadanou hodnotou

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
echo '<input type="text" name="x1" value="'.htmlspecialchars($_REQUEST['x1']).'">';
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
* aplikace dnes často píšeme v UTF-8 - pokud chceme pracovat s řetězci na úrovni znaků, je vhodné použít místo původní funkce její *mb_ alternativu*
* např.:
```php
$delka = mb_strlen($retezec, "utf-8" );
```
* pokud nechceme zadávat kódování u každé MB funkce, je možné nejdřív nastavit výchozí kódování - např. pomocí
```php
/* Set internal character encoding to UTF-8 */
mb_internal_encoding("UTF-8");
```

* [příklad řetězce](./02-retezce.php)
* [příklad formuláře s jednoduchou kontrolou](./02-retezce-formular-kontrola.php)