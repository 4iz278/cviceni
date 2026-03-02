# 4. Objekty v PHP

## Třídy, rozhraní atd.
* základ práce s třídami, rozhraními a dědičností se v PHP vlastně moc neliší od toho, co možná znáte z Javy či např. C#
  * rozdílem je absence datových typů - nejsou povinné, ale je možné je definovat
  * PHP nepodporuje! vícenásobné definice (přetěžování) metod, ale podporuje volitelné parametry (jako např. JavaScript)
  * lze využívat *magické metody* (ale o tom až [později](../05-objekty))
  * **v PHP nejsou třídy automaticky potomkem žádné třídy!** (žádná výchozí třída *Object*)
* budeme se bavit jen o objektech v PHP 8.x (reálně jsou objekty obdobně používány od řady 5, ale postupně se možnosti rozšiřují)
* PHP nevyžaduje, aby byla každá třída v samostatném souboru (ale bývá to dobrým zvykem)
  * v souvislosti s tím PHP neobsahuje standardní mechanismus pro načítání tříd, příslušné zdrojové kódy musí být načteny před použitím objektu
  * je možné definovat vlastní autoload pro načítání požadovaných tříd (viz [4. cvičení](../05-objekty-II#class-loader))

### Definice jednoduché třídy, použití objektů
* třída může (ale nemusí) rozšiřovat jinou třídu
* třída může implementovat rozhraní (i větší množství) - **K čemu jsou dobrá rozhraní?**
* konstruktor definujeme pomocí *__construct()*, ručně ho nevoláme (určitě ne mimo danou třídu), instance vytváříme pomocí *new*
* lze definovat destruktor pomocí *__destruct()* - je volán automaticky při zániku objektu, nelze se na to ale 100% spolehnout (např. při ukončení skriptu kvůli chybě)

```php
class JmenoTridy extends NadrazenaTrida implements Rozhrani1,Rozhrani2 {
  const string KONSTANTA = "hodnota"; //definice konstanty; pokud neuvedete přístupost, je automaticky public
  private string $x = 'a'; //definice private property s výchozí hodnotou
  public string|int $y;        //veřejně dostupná property typu string či int
  protected $z;     //property přístupná z dané třídy a potomků
  public static $a; //statická proměnná třídy, bez určeného datového typu
  private static array $data = []; //statická proměnná, private, s uvedenou výchozí hodnotou

  /**
   *  Konstruktor
   *  @param string $param
   */
  public function __construct(string $param){
    parent::__construct();//zavolání rodičovského konstruktoru - pozor na to, použít pouze pokud jej rodič má definovaný
    $this->y = $param;    //přiřazení hodnoty do property
    $this->mojeFunkce();  //zavolání funkce
  }

  /**
   *  Private funkce, dostupná jen z instance daného objektu
   */
  private function mojeFunkce():void{
    //tělo funkce
    self::statickaFunkce(); //pomocí self přistupujeme ke statickým proměnným a metodám
  }

  /**
   *  Ukázka statické funkce
   *  @return bool
   */
  public static function statickaFunkce():bool{
    //tělo funkce
    return true;
  }
}

$instance = new JmenoTridy("a"); //vytvoření instance
echo $instance->y; //přístup k public property
$instance->cosi = 'a'; //dynamicky definované properties byly ve starším kódu běžně používané, dnes nepoužívat 
JmenoTridy::$a = 1; //přístup k statické proměnné třídy
JmenoTridy::statickaFunkce(); //zavolání statické metody
```

* [příklad objekty - základ](./04-objekty-zaklad.php)

### Abstraktní třídy, rozhraní, dědičnost
* **Víte z jiných programovacích jazyků něco o dědičnosti?**
* **rozhraní** = "šablona" toho, jaké metody musí daná třída obsahovat
  * umožňují jednotný přístup k jednotlivým třídám
* **abstraktní třída** = třída, ve které nejsou definovány některé metody
  * nelze od ní přímo vytvořit instanci - abstraktní metody jsou dodefinovány v potomkovi

```php
interface X{
  public function a():void;
}
abstract class Class1{
  public function b():void{
    //...
  }
  public abstract function c();
}
class Class2 extends Class1 implements X{
  public function a():void{
    //...
  }
  public function c():void{
    //...
  }
}
```

* v PHP samozřejmě existují také možnosti pro ověření, jestli je daný objekt instancí zvolené třídy (i jejího potomka) a zjištění, zda daná třída existuje
  * další užitečné metody jsou **class_exists()**, **property_exists()**, **method_exists()**, **interface_exists()**

```php
  if ($x instanceof MojeTrida){
    //...
  }
```

* [příklad objekty - dědičnost](./04-objekty-dedicnost.php)
* [příklad objekty - interface](./04-objekty-interface.php)
* [příklad objekty - abstraktní třídy](./04-objekty-abstract-class.php)
* [příklad objekty - instanceof](./04-objekty-instanceof.php)

### Definice properties v constructoru
* často používáme konstruktor jen k tomu, abychom zapsali předané hodnoty do properties
* pro zjednodušení lze properties definovat rovnou v konstruktoru

```php
//zápis v běžné podobě
class Uzivatel {
  public string $jmeno;
  public int $vek;
  private ?int $id;
    
  public function __construct(
    string $jmeno,
    int $vek,
    ?int $id = null,
    bool $active=false
  ){  
    $this->jmeno=$jmeno;
    $this->vek=$vek;
    $this->id=$id;
    //TODO zpracování $active
  }
}

//definice properties v konstruktoru
class Uzivatel {
  public function __construct(
    public string $jmeno,
    public int $vek,
    private ?int $id,
    bool $active=false //běžný parametr konstruktoru, nevytváří property
  ){  
    //TODO zpracování $active
  }
}
```

### Readonly properties / class
* **readonly** property je vlastnost, kterou lze nastavit pouze jednou
  * často nastavujeme hodnotu rovnou v konstruktoru (vhodné pro objekty jen přenášející data)
  * po inicializaci už nelze hodnotu změnit
  * readonly property musí mít definovaný datový typ
* pokud jsou v objektu jen readonly properties, může být readonly celá třída

```php
readonly class Uzivatel {
  public function __construct(
    public int $id,
    public string $jmeno
  ){
  }
}

$u = new Uzivatel(1, "Pepa");
//$u->jmeno = "Karel"; // chyba – readonly property
```

* [příklad objekty - readonly](./04-objekty-readonly.php)
* [příklad objekty - immutable](./04-objekty-immutable.php)

### Traity
* trait = v podstatě *kousek definice třídy*
* umožňují částečně řešit problém nemožnosti vícenásobné dědičnosti
* umožňují zapojovat do tříd jen ty funkcionality, které daná třída opravdu potřebuje (například v případě tříd controllerů/presenterů v MVC/MVP)
* definujeme v nich metody a properties, které následně chceme vložit do většího množství tříd
  * vlastnosti definované v traitu se chovají stejně, jako by byly definovány přímo ve třídě
* trait definujeme podobně, jako třídu; do tříd jej zapojujeme pomocí příkazu **use**
* třída může použít libovolné množství traitů, je ale nutné dávat pozor na konfliktní metody a proměnné (lze vyřešit jejich přejmenováním)

```php
trait DemoTrait{
  public function vypis(){
    echo 'lorem ipsum...';
  }
}
class MojeTrida{
  use DemoTrait;
}
$mojeTrida = new MojeTrida();
$mojeTrida->vypis();
```

* [příklad traity - jednoduchý](04-objekty-traity-1.php)
* [příklad traity - jednoduchý s dědičností](04-objekty-traity-2.php)
* [příklad traity - pokročilý](04-objekty-traity-3.php)

### Enum
* enum slouží k definici omezené množiny hodnot
* používáme je tam, kde:
  * hodnota může nabývat jen několika předem daných stavů
  * nahrazují konstanty, magic strings i číselné kódy
* jsou typově bezpečné
* enum je samostatný typ, nikoli třída
* buď může jít o konkrétní výčet hodnot, nebo o enum mapovaný na string nebo int (vhodné pro mapování na stavy v databázi)
* pro práci s enumem s hodnotami lze využívat metody **cases()**, **from()**, **tryFrom()**

```php
//základní tvar enunu bez mapování na hodnoty
enum StavUzivatele {
  case AKTIVNI;
  case BLOKOVANY;
  case ZRUSENY;
}

$stav = StavUzivatele::AKTIVNI;
if ($stav === StavUzivatele::BLOKOVANY){
  // ...
}

//enum s hodnotami (backed enum)
enum Role: string {
  case ADMIN = 'admin';
  case USER = 'user';
  case GUEST = 'guest';
}
$role = Role::ADMIN;
echo $role->value; // "admin"
```

* [příklad enum](04-objekty-enum.php)

### Jmenné prostory (namespaces)
* jmenné prostory slouží k rozdělení kódu do logických částí, podpora v PHP 5.3+
* jedná se o obdobu "balíčků" z Javy či namespaces z C#
* umožňují snazší skládání částí kódu např. z různých knihoven
* jejich **použití je volitelné**
  * pokud nechcete, tak je ve vlastním kódu využívat nemusíte (pokud nepoužijete kód, který je již obsahuje)
  * lze do nich rozdělovat libovolné částí kódu - nejen definice tříd, ale také definice funkcí mimo objekty!

```php
namespace MojeAplikace; //všechen následující kód bude ve jmenném prostoru "MojeAplikace"

use MojeAplikace\Model\User; //import třídy User ze jmenného prostoru \MojeAplikace\Model (budeme ji volat jen jako "Users")

function f1(){
  \PDF\Generator::output();//zavolání statické metody na třídě \PDF\Generator (absolutní cesta)
}

class TridaX{
  public function getNewUser(){
    return new User();//používáme třídu Users
  }
}
```

* [příklad jmenné prostory 1](04-jmenne-prostory-1.php)
* [příklad jmenné prostory 2](04-jmenne-prostory-2.php)
* [příklad jmenné prostory 3 - více souborů](04-jmenne-prostory-3)
* [PHP manuál - vyhodnování jmen v závislosti na jmenných prostorech](http://php.net/manual/en/language.namespaces.rules.php)

## Příklad na procvičení
> Navrhněte základní strukturu objektů pro zachycení cvičení na VŠ
>  * cvičení absolvuje větší množství studentů
>  * cvičení má učitele
>  * cvičení má vztah k nějaké učebně
>  * pro definici tříd Student a Ucitel využijte společnou rodičovskou třídu
>  * zkuste vytvořit instance daných tříd...