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

TODO příklady

### Abstraktní třídy, rozhraní, dědičnost
TODO

### Traity
TODO

### Jmenné prostory (namespaces)
TODO
