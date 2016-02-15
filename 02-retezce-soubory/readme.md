# 2. Řetězce, soubory

## Pole
TODO

### Foreach cyklus
TODO


## GET, POST
TODO

## Řetězcové funkce

## Práce se soubory
* PHP podporuje velké množství funkcí pro práci se soubory
* pokud je povolený *fopen wrapper*, je možné pracovat se vzdálenými soubory obdobně, jako by šlo o soubory lokální
* pozor na přístupová práva k souborům
  * pokud chceme zapisovat do souboru/adresáře, je nutné na většině hostingů upravit dané položce přístupová práva

### Include, require
* PHP nevyžaduje rozdělení aplikace do jednotlivých souborů - i při objektové aplikaci můžeme vše napsat jen do jednoho souboru, ale...
* Pokud se máme v aplikaci vyznat, je vhodné ji rozčlenit na logické celky uložené v samostatných souborech.
* Příkazy *include* a *require* jsou jedním z nejjednodušších využití PHP také na statických stránkách - pro oddělení hlavičky a patičky do samostatného souboru.
* *Include* a *require* mohou být v kódu zapsány jak v podobě funkce, tak také v podobě příkazu (tj. bez závorek).
* Vkládané soubory by měly mít příponu PHP (aby nebylo možné stáhnout jejich zdroják pomocí prohlížeče)
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

### Souborové streamy
TODO