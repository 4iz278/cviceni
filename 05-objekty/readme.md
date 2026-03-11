# 4. Objekty v PHP
:point_right:
* základ práce s třídami, rozhraními a dědičností se v PHP vlastně moc neliší od toho, co možná znáte z Javy či např. C#
  * rozdílem je absence datových typů - nejsou povinné, ale je možné je definovat
  * PHP nepodporuje! vícenásobné definice (přetěžování) metod, ale podporuje volitelné parametry (jako např. JavaScript)
  * lze využívat *magické metody* (ale o tom až [později](../05-objekty))
  * **v PHP nejsou třídy automaticky potomkem žádné třídy!** (žádná výchozí třída *Object*)
* budeme se bavit jen o objektech v PHP 8.x (reálně jsou objekty obdobně používány od řady 5, ale postupně se možnosti rozšiřují)
* PHP nevyžaduje, aby byla každá třída v samostatném souboru (ale bývá to dobrým zvykem)
  * v souvislosti s tím PHP neobsahuje standardní mechanismus pro načítání tříd, příslušné zdrojové kódy musí být načteny před použitím objektu
  * je možné definovat vlastní autoload pro načítání požadovaných tříd (viz [4. cvičení](../05-objekty-II#class-loader))

## Definice jednoduché třídy, použití objektů
:point_right:
* třída může (ale nemusí) rozšiřovat jinou třídu
* třída může implementovat rozhraní (i větší množství) - **K čemu jsou dobrá rozhraní?**
* konstruktor definujeme pomocí *__construct()*, ručně ho nevoláme (určitě ne mimo danou třídu), instance vytváříme pomocí *new*
* lze definovat destruktor pomocí *__destruct()* - je volán automaticky při zániku objektu, nelze se na to ale 100% spolehnout (např. při ukončení skriptu kvůli chybě)

```php
class JmenoTridy extends NadrazenaTrida implements Rozhrani1,Rozhrani2 {
  const string KONSTANTA = "hodnota"; //definice konstanty; pokud neuvedete přístupnost, je automaticky public
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

:blue_book:
* [příklad objekty - základ](05-objekty-zaklad.php)

## Abstraktní třídy, rozhraní, dědičnost
:point_right:
* **Víte z jiných programovacích jazyků něco o dědičnosti?**
* **rozhraní** = "šablona" toho, jaké metody musí daná třída obsahovat
  * umožňují jednotný přístup k jednotlivým třídám
* **abstraktní třída** = třída, která může obsahovat abstraktní (plně nedefinované) metody
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

:point_right:
* v PHP samozřejmě existují také možnosti pro ověření, jestli je daný objekt instancí zvolené třídy (i jejího potomka) a zjištění, zda daná třída existuje
  * další užitečné metody jsou **class_exists()**, **property_exists()**, **method_exists()**, **interface_exists()**

```php
  if ($x instanceof MojeTrida){
    //...
  }
```

:blue_book:
* [příklad objekty - dědičnost](05-objekty-dedicnost.php)
* [příklad objekty - interface](05-objekty-interface.php)
* [příklad objekty - abstraktní třídy](05-objekty-abstract-class.php)
* [příklad objekty - instanceof](05-objekty-instanceof.php)

## Definice properties v constructoru
:point_right:
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

## Readonly properties / class
:point_right:
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

:blue_book:
* [příklad objekty - readonly](05-objekty-readonly.php)
* [příklad objekty - immutable](05-objekty-immutable.php)

### Property hooks (PHP 8.4+)
> [!TIP]
> * od PHP 8.4 je možné definovat logiku, která se provede při čtení nebo zápisu property
>   * není tedy nutné vytvářet a volat vlastní metody typu getXXX / setXXX 
>   * jde vlastně o stejné chování, jaké má např. C#
> * umožňuje:
>   * validaci hodnot 
>   * automatickou úpravu dat 
>   * zapouzdření jednoduché logiky bez setterů/getterů
>   * konverze datového typu property
> * Property hooks jsou vhodné hlavně pro jednoduchou logiku u properties (např. validaci nebo normalizaci hodnot). Složitější operace je stále lepší  řešit pomocí metod.
> ```php
> class Produkt { 
>   public int $cena {
>     set {
>       if ($value < 0) {
>         throw new InvalidArgumentException("Cena nesmí být záporná");
>       }
>       $this->cena = $value;
>     }
>   }
> }
> 
> class Udalost {
>   public DateTimeImmutable $datum {
>     set(string|DateTime|DateTimeImmutable $value) {
>       if (is_string($value)) {
>         $this->datum = new DateTimeImmutable($value);
>       }elseif($value instanceof DateTime){
>         $this->datum = DateTimeImmutable::createFromMutable($value);
>       }else{
>         $this->datum = $value;
>       }
>     }
>   }
> }
> 
> $p = new Produkt();
> 
> $p->cena = 100;   // OK
> $p->cena = -50; // vyhodí výjimku
> 
> $udalost = new Udalost();
> $udalost->datum='2026-12-24'; //hodnota se automaticky převede na DateTimeImmutable
> 
> echo $udalost->datum->format('j.n.Y');
> ```

## Nullsafe operátor
:point_right:
* pro získávání hodnot z objektů, které mohou být null, je výhodné používat tzv. **nullsafe operátor** `?->`
* pokud je objekt `null`, výraz se nevyhodnotí a vrátí se `null` místo vyhození chyby
* zjednodušuje zápis kódu a nahrazuje časté kontroly typu `if ($objekt !== null)`

```php
$uzivatel = $repozitar->najdiUzivatele($id);

// klasický zápis
if ($uzivatel !== null) {
  $email = $uzivatel->getEmail();
}

// nullsafe operátor
$email = $uzivatel?->getEmail();
```

:point_right:
* nullsafe operátor lze také řetězit (podmíněné jsou pak všechny další části výrazu)
* nullsafe operátor je možné **použít pouze pro čtení hodnot či zavolání metody**, nemůže být na levé straně přiřazení 

```php
$email = $objednavka?->getUzivatel()?->getEmail();

//$uzivatel?->jmeno = 'Pepa'; // chyba
```

## Traity
:point_right:
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

:blue_book:
* [příklad traity - jednoduchý](05-objekty-traity-1.php)
* [příklad traity - jednoduchý s dědičností](05-objekty-traity-2.php)
* [příklad traity - pokročilý](05-objekty-traity-3.php)

## Enum
:point_right:
* enum je samostatný typ, nikoli třída
* enum slouží k definici omezené množiny hodnot
* používáme je tam, kde:
  * hodnota může nabývat jen několika předem daných stavů
  * nahrazují konstanty, magic strings i číselné kódy
* jsou typově bezpečné
* buď může jít o konkrétní výčet hodnot, nebo o enum mapovaný na string nebo int (vhodné pro mapování na stavy v databázi)
* pro práci s enumem s hodnotami lze využívat metody **cases()**, **from()**, **tryFrom()**
* enum může implementovat rozhraní

```php
//základní tvar enumu bez mapování na hodnoty
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
enum Role: string{
  case ADMIN = 'admin';
  case USER = 'user';
  case GUEST = 'guest';
}
$role = Role::ADMIN;
echo $role->name; // "ADMIN"
echo $role->value; // "admin"
```

:point_right:
* enum může obsahovat vlastní metody (např. popisky stavů, labely pro UI atp.)
```php
//enum s doplněnou ukázkovou metodou volatelnou na jednotlivých hodnotách
enum Role: string{
  case ADMIN = 'admin';
  case USER = 'user';
  case GUEST = 'guest';

  public function label(): string{
    return match($this) {
      self::ADMIN => 'Administrátor',
      self::USER => 'Uživatel',
      self::GUEST => 'Host',
    };
  }
}

$role = Role::ADMIN;
echo $role->label(); // Administrátor
```

:blue_book:
* [příklad enum](05-objekty-enum.php)

## Jmenné prostory (namespaces)
:point_right:
* jmenné prostory slouží k rozdělení kódu do logických částí, podpora v PHP 5.3+
* jedná se o obdobu "balíčků" z Javy či namespaces z C#
* umožňují snazší skládání částí kódu např. z různých knihoven
* jejich **použití je volitelné**
  * pokud nechcete, tak je ve vlastním kódu využívat nemusíte (pokud nepoužijete kód, který je již obsahuje)
  * lze do nich rozdělovat libovolné částí kódu - nejen definice tříd, ale také definice funkcí mimo objekty!

```php
namespace MojeAplikace; //všechen následující kód bude ve jmenném prostoru "MojeAplikace"

use MojeAplikace\Model\User; //import třídy User ze jmenného prostoru \MojeAplikace\Model (budeme ji volat jen jako "User")

function f1(){
  \PDF\Generator::output();//zavolání statické metody na třídě \PDF\Generator (absolutní cesta)
}

class TridaX{
  public function getNewUser(){
    return new User();//používáme třídu Users
  }
}
```

:blue_book:
* [příklad jmenné prostory 1](05-jmenne-prostory-1.php)
* [příklad jmenné prostory 2](05-jmenne-prostory-2.php)
* [příklad jmenné prostory 3 - více souborů](05-jmenne-prostory-3)
* [PHP manuál - vyhodnování jmen v závislosti na jmenných prostorech](http://php.net/manual/en/language.namespaces.rules.php)

## Příklad na procvičení
:mega:
> Navrhněte základní strukturu objektů pro zachycení cvičení na VŠ
>  * cvičení absolvuje větší množství studentů
>  * cvičení má učitele
>  * cvičení má vztah k nějaké učebně
>  * pro definici tříd Student a Ucitel využijte společnou rodičovskou třídu
>  * zkuste vytvořit instance daných tříd...

:orange_book:
* [možné řešení příkladu na procvičení (kód)](./05-reseni-prikladu)