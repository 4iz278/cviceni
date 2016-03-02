<?php

namespace NS1{

  use NS1\X\Trida2; //chceme používat třídu Trida2 bez prefixu v podobě jmenného prostoru (cesta v USE se uvádí vždy absolutně)

  /**
   * Class Trida1 - třída definovaná ve jmenném prostoru NS1
   * @package NS1
   */
  class Trida1{

    public function test(){
      return 'test';
    }

    public function ukazkaNS(){
      $trida2 = new Trida2();       //třída z jiného jmenného prostoru, která ale byla "importována" pomocí use
      $trida2 = new X\Trida2();     //relativní uvedené jmenného prostoru
      $trida2 = new \NS1\X\Trida2();//
    }

  }

  /**
   * Ukázková funkce - je zahrnutá do jmenného prostoru, ačkoliv to není v definici třídy...
   * @param $str
   */
  function vypis($str){
    echo $str;
  }
  /**
   * @param Trida1 $trida1
   */
  function vypis2(Trida1 $trida1){
    //funkce s typovaným parametrem...
  }

}

namespace NS1\X{//jméno jmenného prostoru může být složeno z více částí, oddělují se \

  use NS1\Trida1 as ZakladniTrida;//chceme používat třídu \NS1\Trida1 pod názvem ZakladniTrida

  use function vypis2; //v PHP 5.6+ je možné importovat také funkce a konstanty

  /**
   * Class Trida2
   * @package NS1\X
   */
  class Trida2{
    /**
     * @return ZakladniTrida
     */
    public function newTrida1(){
      return new ZakladniTrida();
    }
  }

  \NS1\vypis('test');//ukázka zavolání funkce, která je v jiném jmenném prostoru

}
