# 3. Práce se soubory
* PHP podporuje velké množství funkcí pro práci se soubory
* pokud je povolený *fopen wrapper*, je možné pracovat se vzdálenými soubory obdobně, jako by šlo o soubory lokální
  * pozor na to, že ne všude je to povolené
* pozor na přístupová práva k souborům
  * pokud chceme zapisovat do souboru/adresáře, je nutné na většině hostingů upravit dané položce přístupová práva

## Include, require
* PHP nevyžaduje rozdělení aplikace do jednotlivých souborů - i při objektové aplikaci můžeme vše napsat jen do jednoho souboru, ale...
* pokud se máme v aplikaci vyznat, je vhodné ji rozčlenit na logické celky uložené v samostatných souborech
* příkazy *include* a *require* jsou jedním z nejjednodušších využití PHP také na statických stránkách - pro oddělení hlavičky a patičky do samostatného souboru
* *include* a *require* mohou být v kódu zapsány jak v podobě funkce, tak také v podobě příkazu (tj. bez závorek)
* vkládané soubory by měly mít příponu PHP (aby nebylo možné stáhnout jejich zdroják pomocí prohlížeče)
  * v případě neobjektové aplikace je vhodné vkládané soubory oddělit do samostatného adresáře, nebo např. dopsat do jejich názvu *"inc"* => na první pohled je pak zřejmé, že mají být někam vloženy
* *Jaký je rozdíl mezi "include" a "require"?*
  * Pokud se soubor nepodaří načíst, include vypíše upozornění a skript pokračuje, zatímco require běh skriptu ukončí.
* v případě uvedení jen názvu souboru je soubor hledán v tzv. *include path*, doporučuji použít absolutní cestu za využití konstanty **__DIR__**
```php
include "connection.inc.php";
require "connection.inc.php";
include_once "connection.inc.php"; //funkce s "_once" načtou soubor pouze v tom případě, že dosud nebyl načten
require_once "connection.inc.php";

include __DIR__.'/connection.inc.php'; //soubor hledaný v aktuálním adresáři
```

* [příklad include](03-include/index.php)

## Načtení/uložení celého souboru
* celý obsah souboru je možné načíst či uložit pomocí jednoho zavolání funkce

### file_get_contents
* načte celý soubor (pokud by neexistoval, vypíše varování a vrátí false)
* viz [w3schools - PHP file_get_contents() Function](http://www.w3schools.com/php/func_filesystem_file_get_contents.asp)
  * k čemu jsou dobré další atributy dané funkce?
```php
$soubor = file_get_contents(__DIR__.'/soubor.txt');

//pokud nevíme, jestli soubor existuje, tak to nejprve ověříme
if (file_exists(__DIR__.'/soubor.txt')) {
  $soubor = file_get_contents(__DIR__.'/soubor.txt');
}

//pokud víme, že soubor nemusí existovat, a chceme jen potlačit vypsání varování
$soubor = @file_get_contents(__DIR__.'/soubor.txt'); 
if ($soubor!==false){
  //zpracování
}
```

### file_put_contents
* uloží celý soubor (pokud neexistuje, je vytvořen)
* pomocí 3. parametru je možné zapisovat až na konec
* vhodné pro jednorázový zápis (např. poznámka logu, kde nechceme udržovat odkaz na otevřený soubor)
* pozor na to, že je nutné mít povolená práva pro zápis do daného souboru, případně adresáře
```php
file_put_contents('soubor.txt',$data,FILE_APPEND);//připojení obsahu na konec souboru
```

* [příklad file content](../03-soubory/03-file-content.php)


### readfile
* funkce pro odeslání obsahu souboru na výstup (např. pro zabezpečené stahování PHP souborů)
  * neobsah souboru jako svoji návratovou hodnotu
  * pokud chceme korektně nabídnout soubor ke stažení, je nutné doplnit odpovídající hlavičky pomocí funkce *header()*
```php
readfile("soubor.txt");
```
* [příklad readfile](03-readfile/index.php)

## Soubory - čtení, zápis
* základní postup je
  1. otevření souboru (s příslušným modifikátorem přístupu)
  2. potřebné manipulace s obsahem (čtení, zápis)
  3. zavření souboru

```php
$file = @fopen('data.txt','r');  //otevření souboru pro čtení - pozor na to, že potlačujeme možné varování!
if ($file){
  while(($row = fgets($file)) !== false){   //načtení řádku, pokud se jej podaří načíst...
    //zpracování...
  }
  fclose($file);
}

//alternativně s extra kontrolou konce souboru
$file = @fopen('data.txt','r');  //otevření souboru pro čtení - pozor na to, že potlačujeme možné varování!
if ($file){
  while(!feof($file)){   //nedošli jsme zatím na konec souboru?
    $row = fgets($file); //načtení řádku
    //zpracování...
  }
  fclose($file);
}
```

### Kontrola existence a zapisovatelnosti souboru
* **file_exists($jmenoSouboru)**
  * funkce pro kontrolu, zda daný soubor (nebo adresář) existuje

* **is_writable($jmenoSouboru)**
  * funkce pro kontrolu, zda je možné zapisovat do daného souboru (z PHP)

### Potřebné funkce
* **fopen($jmenoSouboru, $pristup)**
  * modifikátory přístupu *r*, *w*, *a*, *r+*, *w+*, *a+*
    * rozhodují o otevření pro čtení, zápis či připojování na konec
    * modifikátory s + umožňují i druhou operaci (např. *r+* umožní i zápis)

* **feof($file)**
  * funkce pro zjištění, zda jsme došli na konec souboru (snažíme se číst za koncem souboru)

* **fread($file, $delka)**
  * čtení ze souboru (pro binární data)

* **fgets($file[, $maximalniDelka])**
  * čtení souboru po řádcích

* **fwrite($file, $data[, $delka])**
  * zápis dat do souboru
  * pokud zadáme délku, data se v případě potřeby příslušně zkrátí (na daný počet bajtů)

* **fclose($file)**
  * zavře soubor
  * pokud dosud nebyla dozapsána nějaká data (jsou zatím v bufferu), dojde k tomu před uzavřením souboru

* **fseek($file, $offset[, $whence])**
  * funkce pro přesun pointeru v souboru
  * *$offset* je určen počtem bytů od začátku souboru
  * volitelně jde zadat parametr *$whence*
    * *SEEK_CUR* - offset bude počítán od aktuální pozice, offset pak může být i záporný

* máme i funkce pro přímou práci s CSV soubory
  * *Co je to CSV soubor?*
  * viz [PHP manuál - fgetcsv](http://php.net/manual/en/function.fgetcsv.php)
  * viz [PHP manuál - fputcsv](http://php.net/manual/en/function.fputcsv.php)


* [příklad čtení souboru](../03-soubory/03-fread.php)
* [příklad zápisu do souboru](03-fwrite.php)
* [příklad čtení CSV](03-csv/fgetcsv.php)
* [příklad kontrola zapisovatelnosti souboru](../03-soubory/03-file-exists.php)


# Příklad na procvičení
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