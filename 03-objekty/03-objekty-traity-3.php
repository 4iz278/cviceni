<?php

/** Ukázka kompozice třídy z většího množství traitů za využití možnosti řešení konfliktních názvů */

trait Trait1{
  public function test(){
    echo 'test 1'.PHP_EOL;
  }
  public function vypis(){
    echo 'vypis 1'.PHP_EOL;
  }
}

trait Trait2{
  public function test(){
    echo 'test 2'.PHP_EOL;
  }
  public function vypis(){
    echo 'vypis 2'.PHP_EOL;
  }
}

trait Trait3{
  protected function hello(){
    echo 'hello'.PHP_EOL;
  }
}

class MojeTrida{
  use Trait1, Trait2{ //načítáme najednou více traitů, přičemž chceme vyřešit konfliktní obsah
    Trait1::test insteadof Trait2; //bude použita metoda test() z Trait1, příslušná metoda z Trait2 bude ignorována
    Trait1::vypis insteadof Trait2;
    Trait2::vypis as vypis2;       //chceme přejmenovat metodu vypis() z Trait2, bude dostupná pod jiným jménem; zároveň je nutné mít vyřešený konflikt s Trait2 (viz předchozí řádek)
  }
  use Trait3{
    hello as public; //změna přístupnosti příslušné metody
    hello as public hello2; //změna přístupnosti  zároveň přejmenování; jednu metodu můžeme převzít dokonce vícekrát...
  }
}

$objekt = new MojeTrida();
$objekt->test();
$objekt->vypis2();
$objekt->hello();
$objekt->hello2();