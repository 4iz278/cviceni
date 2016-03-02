<?php
/** Jednoduchý příklad definice jmenného prostoru a jeho využití */

namespace TestovaciNamespace;
//všechen následující kód bude ve jmenném prostoru TestovaciNamespace
//OBVYKLE SE DEFINIJE KAŽDÁ TŘÍDA DO VLASTNÍHO SOUBORU, NA ZAČÁTKU KAŽDÉHO SOUBORU JE NAPSÁN NAMESPACE
//pokud bychom chtěli omezit rozsah definice jmenného prostoru, je možné příslušný obsah obalit do složených závorek

/**
 * Class Trida1
 * @package TestovaciNamespace
 */
class Trida1{

  public function test(){
    $cislo = Trida2::getX();
    //v objektovém programování samozřejmě nezáleží na tom, jak jsou třídy napsané v souboru za sebou
    //ke třídám ve stejném jmenném prostoru přistupujeme stejně, jako kdybychom jmenné prostory vůbec nepoužívali
    return $cislo+1;
  }

}

/**
 * Class Trida2
 * @package TestovaciNamespace
 */
class Trida2{
  /**
   * @return int
   */
  public static function getX(){
    return 10;
  }
}

$objekt = new Trida1();
echo $objekt->test();