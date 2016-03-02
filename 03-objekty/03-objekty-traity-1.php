<?php

  /**
   * Trait MujTrait
   */
  trait MujTrait{
    private $x = 'neco'; //v rámci definice traitu je možné definovat nejen metody, ale také proměnné (properties)

    /**
     * @return string
     */
    public function getX(){
      return $this->x;
    }

    /**
     * @return int
     */
    protected function getRandomNumber(){
      return rand(1,10);
    }
  }

  /**
   * Class MojeTrida - ukázka třídy s traitem
   */
  class MojeTrida{

    use MujTrait; //pomocí klíčového slova use můžeme načíst příslušný trait

    public function echoX(){
      echo $this->x; //proměnná $x byla sice definovaná v traitu jako private, ale je tu normálně dostupná (obsah traitu je "nakopírován" do této třídy)
    }
  }

  $objekt=new MojeTrida();
  $objekt->echoX();