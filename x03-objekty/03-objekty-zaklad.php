<?php

/**
 * Class MojeTrida - jednoduchá ukázková třída
 */
class MojeTrida{
  //definice konstanty
  const KONSTANTA = 10;

  //definice properties pro vytvářené objekty
  public $a;      //z důvodu kompatibility se starými verzemi PHP je stejnou konstrukcí zápis s použitím klíčového slova var (misto public)
  protected $b;
  private $c;

  //definice statických proměnných (jsou společné pro všechny instance dané třídy)
  public static $d;
  protected static $e;
  private static $f = 0; //u každé definice proměnné můžeme rovnou zadat její výchozí hodnotu

  public function __construct(){
    //konstruktor pro vytvoření nového konstruktoru (je volán automaticky při vytváření nové instance)
  }
  public function __destruct(){
    //volitelný destruktor (provádí se při rušení objektu)
  }

  /**
   * Metoda vracející náhodné číslo
   * @return int
   */
  private function privatniFunkce(){
    return rand();
  }

  public function vypis(){
    $vysledek = $this->b + $this->privatniFunkce();
    //k metodám i proměnným přistupujeme přes ->
    //v rámci dané instance využíváme klíčové slovo $this
    //u properties (proměnných) nepíšeme $ !

    $this->neco = 'nevim';//PHP se vyrovná i s dynamickým definováním properties, jsou pak nadefinovány jako public

    echo $vysledek;
  }

  /**
   * @return int
   */
  public static function statickaFunkce(){
    self::$f++; //ke statickým proměnným, konstantám a metodám přistupujeme přes operátor :: (dvě dvojtečky), u proměnných je uveden $
    return self::KONSTANTA + self::$f; //uvnitř třídy používáme místo jména třídy klíčové slovo self
  }

}


echo MojeTrida::statickaFunkce(); //zavolání statické funkce
echo MojeTrida::KONSTANTA;        //ke konstantám a statickým public proměnným jde přistupovat i mimo třídu
echo MojeTrida::$d;

$objekt = new MojeTrida(); //vytvoření nového objektu (pro vytvoření se používá konstruktor)
$objekt->a = 0;     //přístup k public proměnné
$objekt->vypis();   //přístup k metodě daného objektu