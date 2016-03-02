<?php

  /**
   * Class Trida - ukázka jednoduché třídy, kterou je možné zavolat jako funkci
   */
  class Trida {

    /**
     * Metoda volaná v případě zavolání třídy jako funkce
     * @param $x
     */
    public function __invoke($x){
      var_dump($x);
    }

  }

  $objekt = new Trida();
  $objekt(5);