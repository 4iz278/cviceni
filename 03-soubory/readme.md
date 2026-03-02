# 3. Práce se soubory
* PHP podporuje velké množství funkcí pro práci se soubory
* pokud je povolený *fopen wrapper*, je možné pracovat se vzdálenými soubory obdobně, jako by šlo o soubory lokální
* pozor na přístupová práva k souborům
  * pokud chceme zapisovat do souboru/adresáře, je nutné na většině hostingů upravit dané položce přístupová práva

## Include, require
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
* [příklad include](../03-soubory/02-include/index.php)

## Načtení/uložení celého souboru
* celý obsah souboru je možné načíst či uložit pomocí jednoho zavolání funkce

### file_get_contents
* načte celý soubor
* viz [w3schools - PHP file_get_contents() Function](http://www.w3schools.com/php/func_filesystem_file_get_contents.asp)
  * k čemu jsou dobré další atributy dané funkce?
```php
$soubor = file_get_contents('soubor.txt');
```
### file_put_contents
* uloží celý soubor
* pomocí 3. parametru je možné zapisovat až na konec
* vhodné pro jednorázový zápis (např. poznámka logu, kde nechceme udržovat odkaz na otevřený soubor)
```php
file_put_contents('soubor.txt',$data,FILE_APPEND);//připojení obsahu na konec souboru
```

* [příklad file content](../03-soubory/02-file-content.php)


### readfile
* funkce pro odeslání obsahu souboru na výstup (např. pro zabezpečené stahování PHP souborů)
  * pokud chceme korektně nabídnout soubor ke stažení, je nutné doplnit odpovídající hlavičky pomocí funkce *header()*
```php
readfile("soubor.txt");
```
* [příklad readfile](../03-soubory/02-readfile/index.php)

## Soubory - čtení, zápis
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

### Kontrola existence a zapisovatelnosti souboru
* **file_exists($jmenoSouboru)**
  * funkce pro kontrolu, zda daný soubor existuje

* **is_writable($jmenoSouboru)**
  * funkce pro kontrolu, zda je možné zapisovat do daného souboru

### Potřebné funkce
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


* [příklad čtení souboru](../03-soubory/02-fread.php)
* [příklad zápisu do souboru](../03-soubory/02-fwrite.php)
* [příklad čtení CSV](../03-soubory/02-csv/fgetcsv.php)
* [příklad kontrola zapisovatelnosti souboru](../03-soubory/02-file-exists.php)


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