<?php

  class Trida{
    /**
     * Funkce volaná v případě volání neexistující metody objektu
     * @param string $name
     * @param $argumenty
     */
    public function __call($name, $argumenty){
      echo 'byla zavolána metoda '.$name.PHP_EOL;
      var_dump($argumenty);
    }

    /**
     * Funkce volaná v případě volání neexistující statické metody objektu
     * @param string $name
     * @param $argumenty
     */
    public static function __callStatic($name, $argumenty){
      echo 'byla zavolána statickámetoda '.$name.PHP_EOL;
      var_dump($argumenty);
    }

    public static function test(){
      echo 'normální statická metoda test';
    }

    // v PHP 5.6+ je možné definovat parametr, který shromáždí všechny parametry do pole
    public static function test2(...$params){
      echo 'normální statická metoda';
    }
  }

  $objekt = new Trida();

  $objekt->nejakaFunkce();

  $objekt->jinaFunkce('a');

  Trida::statickaFunkce('a','b','c');

  Trida::test();
  Trida::test('a');//to, že do volání metody napíšeme parametr, který daná metoda nemá, PHP odignoruje

  Trida::test2('a','b');