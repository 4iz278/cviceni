# 3. Objekty v PHP, soubory

## Práce se souborovým systémem
* na [minulém cvičení](../02-retezce-soubory) jsme se zabývali prací s obsahem souborů
* PHP samozřejmě disponuje také funkcemi pro práci s celými soubory
* nejčastěji užívané funkce:
  * **copy($source, $dest)**
    * funkce pro zkopírování souboru
  * **rename($source, $dest)**
    * funkce pro přejmenování či přesun souboru či adresáře
  * **unlink($file)**
    * smazání souboru
  * **mkdir($dir)**
    * funkce vytvoření adresáře
  * **rmdir($dir)**
    * funkce pro smazání prázdného adresáře
  * **file_exists($file)**
    * funkce pro zjištění existence souboru či adresáře
  * **move_uploaded_file($source, $dest)**
    * funkce pro přesun nahraného souboru

* [příklad kontrola čtení/zápisu](./03-soubory-stav.php)
* [příklad manipulace se soubory](./03-soubory-manipulace.php)
* [příklad výpis adresáře](./03-soubory-scandir.php)

## Třídy, rozhraní atd.
* základ práce s třídami, rozhraními a dědičností se v PHP vlastně moc neliší od toho, co znáte z Javy
  * rozdílem je absence datových typů
  * je možné dynamicky definovat properties
  * PHP nepodporuje! vícenásobné definice metod
  * lze využívat *magické metody* (ale o tom až na [4. cvičení](../04-objekty-II-validace))
  * **v PHP nejsou třídy automaticky potomkem žádné třídy!** (žádná výchozí třída *Object*)
* budeme se bavit jen o objektech v PHP 5 (potažmo 7), ne v PHP 4 - tam se používaly jiné definice
* PHP nevyžaduje, aby byla každá třída v samostatném souboru (ale bývá to dobrým zvykem)
  * v souvislosti s tím PHP neobsahuje standardní mechanismus pro načítání tříd, příslušné zdrojové kódy musí být načteny před použitím objektu
  * je možné definovat vlastní autoload pro načítání požadovaných tříd (viz [4. cvičení](../04-objekty-II-validace#class-loader))

### Definice jednoduché třídy, použití objektů
* třída může (ale nemusí) rozšiřovat jinou třídu
* třída může implementovat rozhraní (i větší množství) - **K čemu jsou dobrá rozhraní?**
* konstruktor definujeme pomocí *__construct()*, ručně ho nevoláme (určitě ne mimo danou třídu), instance vytváříme pomocí *new*
* lze definovat destruktor pomocí *__destruct()* - je volán automaticky při mazání objektu z paměti, nelze se na to ale 100% spolehnout (např. při ukončení skriptu kvůli chybě)

```php
class JmenoTridy extends NadrazenaTrida implements Rozhrani1,Rozhrani2 {
  const KONSTANTA = "hodnota"; //definice konstanty
  private $x = 'a'; //definice private property s výchozí hodnotou
  public $y;        //veřejně dostupná property
  protected $z;     //property chráněná proti překrytí v dědičné třídě
  static $a; //statická proměnná třídy

  /**
   *  Konstruktor
   *  @param string $param
   */
  public function __construct($param){
    parent::__construct();//zavolání rodičovského konstruktoru
    $this->y = $param;    //přiřazení hodnoty do property
    $this->mojeFunkce();  //zavolání funkce
  }

  /**
   *  Private funkce, dostupná jen z instance daného objektu
   */
  private function mojeFunkce(){
    //tělo funkce
    self::statickaFunkce(); //pomocí self přistupujeme ke statickým proměnným a metodám
  }

  /**
   *  Ukázka statické funkce
   *  @return bool
   */
  public static function statickaFunkce(){
    //tělo funkce
    return true;
  }
}

$instance = new JmenoTridy("a"); //vytvoření instance
echo $instance->$y; //přístup k public property
$instance->cosi = 'a'; //dynamicky definovaná property je vytvořena jako public
JmenoTridy::$a = 1; //přístup k statické proměnné třídy
JmenoTridy::statickaFunkce() //zavolání statické metody
```

* [příklad objekty - základ](./03-objekty-zaklad.php)

### Abstraktní třídy, rozhraní, dědičnost
* **Pamatujete si z Javy něco o dědičnosti?**
* **rozhraní** = "šablona" toho, jaké metody musí daná třída obsahovat
  * umožňují jednotný přístup k jednotlivým třídám
* **abstraktní třída** = třída, ve které nejsou definovány některé metody
  * nelze od ní přímo vytvořit instanci - abstraktní metody jsou dodefinovány v potomkovi

```php
interface X{
  public function a();
}
abstract class Class1{
  public function b(){
    //...
  }
  public abstract function c();
}
class Class2 extends Class1 implements X{
  public function a(){
    //...
  }
  public function c(){
    //...
  }
}
```

* v PHP samozřejmě existují také možnosti pro ověření, jestli je daný objekt instancí zvolené třídy a zjištění, zda daná třída existuje

```php
  if ($x instanceof MojeTrida){
    //...
  }
```

* [příklad objekty - dědičnost](./03-objekty-dedicnost.php)
* [příklad objekty - interface](./03-objekty-interface.php)
* [příklad objekty - abstraktní třídy](./03-objekty-abstract-class.php)
* [příklad objekty - instanceof](./03-objekty-instanceof.php)

### Traity
* trait = v podstatě *kousek definice třídy*, podporováno v PHP 5.4+
* umožňují vyřešit problém nemožnosti vícenásobné dědičnosti
* umožňují zapojovat do tříd jen ty funkcionality, které daná třída opravdu potřebuje (například v případě tříd controllerů/presenterů v MVC/MVP)
* definujeme v nich metody a properties, které následně chceme vložit do většího množství tříd
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

* [příklad traity - jednoduchý](./03-objekty-traity-1.php)
* [příklad traity - jednoduchý s dědičností](./03-objekty-traity-2.php)
* [příklad traity - pokročilý](./03-objekty-traity-3.php)

### Jmenné prostory (namespaces)
* jmenné prostory slouží k rozdělení kódu do logických částí, podpora v PHP 5.3+
* jedná se o obdobu "balíčků" z Javy
* umožňují snazší skládání částí kódu např. z různých knihoven
* jejich **použití je volitelné**
  * pokud nechcete, tak je ve vlastním kódu využívat nemusíte (pokud nepoužijete kód, který je již obsahuje)
  * lze do nich rozdělovat libovolné částí kódu - nejen definice tříd, ale také

```php
namespace MojeAplikace; //všechen následující kód bude ve jmenném prostoru "MojeAplikace"

use MojeAplikace\Model\User; //import třídy Users ze jmenného prostoru \MojeAplikace\Model (budeme ji volat jen jako "Users")

function f1(){
  \PDF\Generator::output();//zavolání statické metody na třídě \PDF\Generator (absolutní cesta)
}

class TridaX{
  public function getNewUser(){
    return new User();//používáme třídu Users
  }
}
```

* [příklad jmenné prostory 1](./03-jmenne-prostory-1.php)
* [příklad jmenné prostory 2](./03-jmenne-prostory-2.php)
* [příklad jmenné prostory 3 - více souborů](./03-jmenne-prostory-3)
* [PHP manuál - vyhodnování jmen v závislosti na jmenných prostorech](http://php.net/manual/en/language.namespaces.rules.php)

## Chyby a výjimky
* **chyba != výjimka**

### Chyby a jejich odchytávání
* některé typy chyb již známe - např. se nepovede otevřít zvolený soubor, vypisujeme neexistující proměnnou atp.
* PHP obsahuje definici řady konstant určujících úroveň generování chyb (např. *E_NOTICE*, *E_WARNING*, ... *E_ALL*), v souvislosti s přechody mezi různými verzi PHP je důležitá také chyba *E_DEPRECATED*
* vyhazování chyb do výstupu závisí na nastavení PHP
* **chyby neslouží k řízení průběhu programu!**
* nejsou odchytitelné klasickými konstrukcemi známými např. z Javy, ale můžeme je ošetřit vlastní funkcí, nebo je skrýt

* [příklad error - zavináč](./03-error-zavinac.php)
* [příklad error handler](./03-error-handler.php)
* [příklad error_reporting](./03-error-reporting.php)
* [příklad error_reporting](./03-error-htaccess.txt)

### Exceptions
* výjimka (Exception) = instance třídy vygenerovaná v případě odchycení nestandartního stavu aplikace
  * lze definovat vlastní odvozené třídy
* lze je využít k řízení kódu programu, lze je odchytit pomocí try-catch bloku
* většina výchozích PHP funkcí výjimky nepoužívá

```php
try{
  //kód, u kterého je možný výskyt výjimky
}catch(\Exception $e){
  //kód obsahující ošetření výjimky
}finally{
  //kód provedený po try bloku a případném provedení kódu pro ošetření výjimky
  //podpora v PHP 5.5+
}
```

* [příklad exceptions](./03-exceptions.php)
* [PHP manuál - vlastní výjimky](http://php.net/manual/en/language.exceptions.extending.php)

## Příklad na procvičení
> Navrhněte základní strukturu objektů pro zachycení cvičení na VŠ
>  * cvičení absolvuje větší množství studentů
>  * cvičení má učitele
>  * cvičení má vztah k nějaké učebně
>  * pro definici tříd Student a Ucitel využijte společnou rodičovskou třídu
>  * zkuste vytvořit instance daných tříd...