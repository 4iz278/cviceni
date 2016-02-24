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

* **array_key_exists($klic, $pole)**
  * funkce pro kontrolu, jestli je v poli daný klíč

* **array_merge($pole, $pole2)**
  * funkce pro sloučení dvou polí

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
* data získáváme od uživatelů nejčastěji z URL adres a pomocí formulářů
  * pokud nevíte jak napsat formulář, zkuste mrknout na [podklady z 4iz268](https://github.com/4iz268/cviceni/tree/master/10-formulare)

* [příklad GET request](./02-get.php)
* [příklad formulář s metodou POST](./02-formular-post.php)
* [opakování z 4iz268 - Základní formulářové prvky](https://github.com/4iz268/cviceni/blob/master/10-formulare/10-form-prvky.html)
* [opakování z 4iz268 - Nové formulářové prvky v HTML 5](https://github.com/4iz268/cviceni/blob/master/10-formulare/10-form-nove-prvky-html5.html)

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
* [příklad include](./02-include/index.php)

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

* [příklad file content](./02-file-content.php)


#### readfile
* funkce pro odeslání obsahu souboru na výstup (např. pro zabezpečené stahování PHP souborů)
  * pokud chceme korektně nabídnout soubor ke stažení, je nutné doplnit odpovídající hlavičky pomocí funkce *header()*
```php
readfile("soubor.txt");
```
* [příklad readfile](./02-readfile/index.php)

### Soubory - čtení, zápis
* základní postup je
  1. otevření souboru (s příslušným modifikátorem přístupu)
  2. potřebné manipulace s obsahem (čtení, zápis)
  3. zavření souboru

```php
$file = @fopen('data.txt','r');  //otevření souboru pro čtení
if ($file){
  while(!feof($file)){   //nedošli jsme zatím na konec souboru?
    $row = fgets($file); //načtení řádku
    //zpracování...
  }
  fclose($file);
}
```

#### Kontrola existence a zapisovatelnosti souboru
* **file_exists($jmenoSouboru)**
  * funkce pro kontrolu, zda daný soubor existuje

* **is_writable($jmenoSouboru)**
  * funkce pro kontrolu, zda je možné zapisovat do daného souboru

#### Potřebné funkce
* **fopen($jmenoSouboru, $pristup)**
  * modifikátory přístupu *r*, *w*, *a*, *r+*, *w+*, *a+*

* **feof($file)**
  * funkce pro zjištění, zda jsme došli na konec souboru

* **fread($file, $delka)**
  * čtení ze souboru (pro binární data)

* **fgets($file[, $maximalniDelka])**
  * čtení souboru po řádcích

* **fwrite($file, $data[, $delka])**
  * zápis dat do souboru
  * pokud zadáme délku, jsou data buď příslušně zkrácena, nebo doplněna mezerami na danou délku

* **fclose($file)**
  * zavře soubor
  * pokud dosud nebyla dozapsána nějaká data (jsou zatím v bufferu), dojde k tomu před uzavřením souboru

* **fseek($file, $offset[, $whence])**
  * funkce pro přesun pointeru v souboru
  * *$offset* je určen počtem bytů od začátku souboru
  * volitelně jde zadat parametr *$whence*
    * SEEK_CUR - offset bude počítán od aktuální pozice, offset pak může být i záporný

* máme i funkce pro přímou práci s CSV soubory
  * *Co je to CSV soubor?*
  * viz [PHP manuál - fgetcsv](http://php.net/manual/en/function.fgetcsv.php)
  * viz [PHP manuál - fputcsv](http://php.net/manual/en/function.fputcsv.php)


* [příklad čtení souboru](./02-fread.php)
* [příklad zápisu do souboru](./02-fwrite.php)
* [příklad čtení CSV](./02-csv/fgetcsv.php)
* [příklad kontrola zapisovatelnosti souboru](./02-file-exists.php)


## Příklad na procvičení
> Vytvořte jednoduchou knihu návštěv, která bude mít všechna data uložena v textovém souboru.
> Chcete trochu napovědět?
> - stránka bude obsahovat formulář, pomocí kterého uživatel zadá své jméno, text příspěvku a e-mail (volitelný)
> - pod formulářem budou vypsány již existující příspěvky
> - data v souboru budou uložena v podobě, ve které se budou přímo zobrazovat na webu
>   - nezapomeňte na to, že uživatelé (a roboti) zadávají často do formulářů věci, které tam nepatří...
> - pro vložení aktuálního data využijte konstrukci
> ```php
> $datum = date('d.m.Y H:i:s');
> ```

## DÚ
> Zjistěte, k čemu je dobrá a jak se používá funkce **sprintf()**.