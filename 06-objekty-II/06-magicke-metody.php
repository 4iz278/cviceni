<?php

  class Trida{
    /**
     * Funkce volaná v případě volání neexistující metody objektu
     */
    public function __call(string $name, array $argumenty):void{
      echo 'byla zavolána metoda '.$name.PHP_EOL;//ladicí výpisy jsou tu uvedeny jen pro účel výuky, místo nich by tu samozřejmě byl příslušný kód k vykonání
      var_dump($argumenty);
    }

    /**
     * Funkce volaná v případě volání neexistující statické metody objektu
     */
    public static function __callStatic(string $name, array $argumenty):void{
      echo 'byla zavolána statickámetoda '.$name.PHP_EOL;
      var_dump($argumenty);
    }

    public static function test():void{
      echo 'normální statická metoda test';
    }

    // variadický parametr – shromáždí všechny předané argumenty do pole
    public static function test2(...$params):void{
      echo 'normální statická metoda';
    }
  }

  $objekt = new Trida();

  $objekt->nejakaFunkce();

  $objekt->jinaFunkce('a');

  Trida::statickaFunkce('a','b','c');

  Trida::test();
  Trida::test('a'); // v novějších verzích PHP může vyvolat varování / chybu (příliš mnoho argumentů) - staré verze PHP příliš mnoho parametrů ignorovaly

  Trida::test2('a','b');