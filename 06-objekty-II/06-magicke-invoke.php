<?php

  /**
   * Class Trida - ukázka jednoduché třídy, jejíž instanci je možné zavolat jako funkci
   * (např. při předání objektu jako callbacku)
   */
  class Trida {

    /**
     * Metoda volaná v případě zavolání objektu jako funkce
     * @param $x
     */
    public function __invoke(mixed $x):void{
      var_dump($x);
    }

  }

  $objekt = new Trida();
  $objekt(5);