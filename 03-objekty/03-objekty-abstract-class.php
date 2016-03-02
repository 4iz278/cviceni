<?php

  /**
   * Class Trida0
   */
  class Trida0{
    public  $a = 1;
  }

  /**
   * Class Trida1 - ukázka abstraktní třídy
   */
  abstract class Trida1 extends Trida0{//abstraktní třída může být potomkem normální či abstraktní třídy a samozřejmě může implementovat rozhraní...
    /** @var int $x */
    protected $x = 10;

    /**
     * @return int
     */
    public function getX(){
      return $this->x;
    }

    /**
     * @return float
     */
    public abstract function calculate();

  }

  /**
   * Class Trida2 - ukázka třídy, která je potomkem třídy abstraktní
   */
  class Trida2 extends Trida1{

    /**
     * @return float
     */
    public function calculate(){ //implementovaná funkce vyžadovaná abstraktní třídou
      return $this->a + $this->x;//TODO odkud pocházejí proměnné $x a $a?
    }
  }


  $test = new Trida0();

  var_dump($test);

  $test2 = new Trida2();
  $test2->a = 5;
  var_dump($test2->calculate());
  var_dump($test2);

  $test3 = new Trida1();//tohle asi neprojde, že...??? (proč?)
