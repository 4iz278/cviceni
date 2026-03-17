# 6. Objekty v PHP II.

* tyto podklady navazují na [informace o základních konstruktech objektového PHP](../05-objekty) (class, enum, interface, trait, jmenné prostory)
* v těchto podkladech se podíváme zejména na [magické metody] a [autoload tříd]

## Magické metody objektů
:point_right: 

* **To, že v rámci daného objektu nějaká vlastnost nebo metoda neexistuje, ještě neznamená, že s ní nejde pracovat..**
* Magické metody nám umí např. nasimulovat proměnné načítané dynamicky z databáze atp.  
* Všechny "magické metody" poznáte podle toho, že začínají na ```__``` (dvě podtržítka)
* Mezi magické metody patří také 3, které už vlastně znáte:
  * **__construct** - používá se při vytvoření instance objektu 
  * **__destruct** - pro "uklizení" po objektu (např. odpojení se od databáze atp.) při ukončení jeho existence, 
  * **__toString** - metoda automaticky volaná při přetypování objektu na string.

### Přístup k neexistujícím/nepřístupným proměnným
:point_right:
* V případě, kdy se snažíme pracovat s nějakou neexistující či nepřístupnou proměnnou, PHP místo vyhození chyby nejprve zkusí zavolat funkci, která může "podstrčit" příslušný obsah.
  * Pokud umí magická metoda pracovat s proměnnou s daným jménem, tak se to pro vnější kód tváří tak, jako kdyby v daném objektu ta proměnná opravdu byla.
  * Často jsou využívané např. pro dynamicky načítané objekty (XML struktura atp.), objektově-relační mapování atp.
  * Některé frameworky pomocí nich např. simulují klasické "properties" á la C# (private proměnná s get() a set()) - byť v PHP 8.4+ už to [umí PHP nativně](../05-objekty#property-hooks-php-84)
* Od PHP 8.2 jsou dynamicky vytvářené properties označené jako deprecated. Magické metody (```__get```, ```__set```) jsou proto jedním z doporučených způsobů, jak implementovat dynamické chování objektů.
* :grey_exclamation: Pozor na to PHP brání rekurzivnímu zacyklení v rámci magických metod - tj. pokud v rámci ```__get``` zkusíme přistupovat k neexistující proměnné, nedojde k rekurzivnímu volání (je možné ho vynutit jen ručním zavoláním ```__get()```)

* **__get(jmenoPromenne)**
  * funkce zavolaná v situaci, kdy chceme načíst neexistující či nepřístupné proměnné
* **__set(jmenoPromenne, prirazovanaHodnota)**
  * funkce zavolaná v situaci, kdy chceme přiřadit obsah do neexistující či nepřístupné proměnné
* **__isset(jmenoPromenne)**
  * funkce zavolaná v situaci, kdy zavoláme *isset()* nebo *empty()* na neexistující či nepřístupné proměnné
* **__unset(jmenoPromenne)**
  * funkce zavolaná v situaci, kdy zavoláme *unset()* na neexistující či nepřístupné proměnné

:blue_book:
* [příklad neexistující proměnné](06-magicke-promenne.php)
* [příklad simulace properties](06-magicke-getset.php)


### Přístup k nedefinovaným/nepřístupným metodám
:point_right:
* Obdobně, jako k nedefinovaným či private proměnným, můžeme přistupovat také k nedefinovaným či private metodám. Při zavolání takové metody dojde k zavolání jedné z následujících funkcí, která může vykonat požadovaný kód stejně, jako by daná metoda definována byla.   
* **__call(jmenoMetody, argumenty)**
  * funkce volaná v případě volání neexistující metody
* **__callStatic(jmenoMetody, argumenty)**
  * funkce volaná v případě volání neexistující statické metody

:blue_book:
* [příklad neexistující metody](06-magicke-metody.php)

### Serializace a "uspávání" objektů
:point_right:
* **Co to je serializace?**
  * serializace znamená převod objektu do řetězce, který je možné uložit do souboru, databáze, cache atp.
  * v PHP je možné určit, které vlastnosti objektu se mají serializovat.  
* v rámci PHP serializace jsou uchovány informace o datových typech proměnných, vnitřní struktuře atp. a např. u řetězců či polí je pro ověření zapsána do serializovaného řetězce i jejich délka    
* aktuální přístup k serializaci (v PHP 8.x) využívá metody **__serialize()** a **__unserialize()**, které umožňují přesně definovat, jaká data se mají uložit
* alternativně lze použít starší metody **__sleep()** a **__wakeup()** (jednodušší, historický mechanismus)
* :grey_exclamation: Pozor – funkce unserialize() může být bezpečnostní riziko, pokud zpracovává data od uživatele.

:blue_book:
* [příklad serialize-unserialize](06-serialize.php)
* [příklad sleep-wake up](06-sleep-wakeup.php)

:point_right:
* Až se budeme [bavit o formátu JSON ](../x09-uzivatele-db-json-xml), vzpomeňte si ještě na podobné rozhraní - *JsonSerializable*.
* Pokud budete chtít celé objekty ukládat do databáze a nebudete je chtít rozepisovat do jednotlivých sloupců v tabulce (např. nějakou konfiguraci, kterou budete načítat vždy jako celek), doporučuji z praxe spíš serializovat daný objekt do JSONu, než pomocí PHP serializace. Už kvůli tomu, že JSON načtete i z libovolného jiného jazyka, ale PHP serializaci ne. Zároveň v JSONu nejsou kontrolovány např. délky řetězců - za což budete rádi, až budete chtít některý z nich nahradit jinou hodnotou např. při migraci na jinou doménu.

### Další magické metody
:point_right:

Kromě výše uvedených existují i další magické metody, byť se nepoužívají až tak často. Např.:

* **__clone()**
  * funkce volaná v případě, že chceme vytvořit klon daného objektu (samostatnou kopii) pomocí příkazu ```clone```
  * při běžném přiřazení proměnné s objektem se kopíruje reference na stejný objekt
  * pokud chceme vytvořit samostatnou kopii objektu, použijeme klonování
* **__invoke()**
  * funkce volaná v případě, kdy se pokusíme zavolat objekt jako funkci
  * daný objekt je potom klasifikován jako *callable*
* **__set_state()**
  * funkce volaná v případě využití funkce *var_export($objekt)*
* **__debugInfo()**
  * funkce volaná v případě využití funkce *var_dump($objekt)*

:blue_book:
* [příklad clone](06-magicke-clone.php)
* [příklad toString](06-magicke-toString.php)
* [příklad invoke](06-magicke-invoke.php)
* [PHP manuál - Magické metody](https://www.php.net/manual/en/language.oop5.magic.php)


## Automatické načítání tříd
:point_right:

* V moderním PHP se běžně používá objektově orientované programování. Narozdíl např. od javy v něm ale nejsou žádná striktní pravidla ohledně toho, jak rozmístit kód do jednotlivých souborů.
* **Obvykle uvádíme každou třídu, rozhraní či trait v samostatném souboru, přičemž je rozmisťujeme do adresářů buď podle jmenných prostorů, nebo podle jejich logické funkce.**
* Rozčleňování kódu do většího množství souborů (obvykle v podstatě každá třída zvlášť) přispívá k jednodušší orientaci ve zdrojácích
* Pro vykonání kódu potřebujeme ale všechen kód "na jednom místě" a načítání souborů pomocí *require_once* je velmi nepraktické (a vede k chybám v případě, že na něco zapomeneme). 


### Class loader
:point_right:

* PHP obsahuje mechanismus pro automatické načítání tříd (autoload), ale je nutné zaregistrovat funkci, která bude načítání provádět.

```php
spl_autoload_register(function($name){
  // funkce se pokusí načíst soubor s definicí dané třídy
});
```

* Autoload funkcí je možné zaregistrovat i větší množství, volají se postupně, jak byly zaregistrovány do fronty (dokud není třída nalezena)
  * pole zaregistrovaných funkcí je možné získat pomocí ```spl_autoload_functions()```, zvolenou funkci je možné odstranit pomocí ```spl_autoload_unregister()```


:blue_book:
* [příklad autoload](./06-autoload)
* [příklad autoload funkce pracující se jmennými prostory](06-autoload-namespaces)


### Načítání tříd při použítí frameworku
:point_right:

* v podstatě všechny PHP frameworky zahrnuje nějakou vlastní podobu autoloadu => **při použití frameworku obvykle neimplementujeme vlastní autoload**
* často je očekáváno rozdělení souborů do pevně daných adresářů (*controllers*, *model* atp.), nebo načítání podle jmenných prostorů
* zajímavou metodu implementuje např. Nette - jeho komponenta RobotLoader naindexuje všechny třídy v zadaném adresáři (bez ohledu na jejich umístění v podadresářích)


### Composer
:point_right:

* Pokud chceme pracovat s externími balíčky, je v PHP obvyklé neskládat dané kódy ručně, ale zpracovat závislosti projektu pomocí composeru.
* **Composer = správce závislostí pro PHP projekty**
  * viz http://getcomposer.org
  * distribuován v podobě PHAR archívu (= spustitelný ZIP archív obsahující PHP skripty), ale např. na windows si ho můžete nainstalovat také pomocí běžného instalátoru.
* Jako správce balíčků se používá [Packagist](https://packagist.org/), nebo GITové úložiště (nejčastěji GitHub)
  * Můžete si definovat vlastní znovupoužitelné komponenty, které jednoduše začleníte do většího množství projektů.
  * Pokud je použitá komponenta závislá na dalších komponentách, composer automaticky vyřeší a stáhne i všechny její závislosti.

     
:point_right:

**Postup použití composeru:**
  1. stáhneme/nainstalujeme composer
  2. definujeme soubor **composer.json**
    * v rámci tohoto souboru jsou definovány všechny závislosti
    * alternativně se dá composer kompletně ovládat konzolovými příkazy (i tak si ale vytvoří composer.json pro zápis konfigurace)
  3. necháme composer stáhnout veškeré potřebné balíčky (obykle jsou umístěny do složky *vendor*)
  4. v rámci aplikace načítáme jen jeden soubor (*autoload.php*), v rámci kterého jsou vygenerovány instrukce pro načítání všech zahrnutých tříd

Následující kód je velmi jednoduchou ukázkou projektu se závislostí definovanou pro composer. Konkrétně stahujeme knihovnu mpdf, která se používá pro jednoduché vytváření PDF souborů.
```json
{
  "name": "4iz278/03-composer-example-project",
  "description": "Ukázkový project",
  "require": {
    "mpdf/mpdf": "^v8.0"
  }
}
```

Následující příkaz spuštěný v příkazovém řádků/konzoli nám stáhne všechny závislosti, či balíčky v rámci možností zaktualizuje na novější verze.
```
php composer.phar update
```

**Jak to pak použít ve vlastní aplikaci**
* autoload.php vytvořený Composerem zajišťuje načítání tříd jak z externích balíčků, tak v případě správné konfigurace i z vlastního kódu (např. pomocí PSR-4).

:blue_book:
* [příklad s načítáním vlastních tříd - PSR4](06-composer-psr4)
* [příklad composer](06-composer-example-project)
  * pro spuštění nastavte práva pro složku *tmp* na 777
  * případně koukněte také na [dokumentaci Mpdf](https://mpdf.github.io/)
