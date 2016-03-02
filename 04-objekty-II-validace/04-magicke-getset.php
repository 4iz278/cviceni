<?php

  /**
   * Trait ObjectWithProperties - ukázka implementace properties
   */
  trait ObjectWithProperties{
    /**
     * @param string $propertyName
     * @return mixed
     */
    public function __get($propertyName){
      if (property_exists($this, $propertyName)){
        $getterName='get'.ucfirst($propertyName);
        if (method_exists($this,$getterName)){
          return $this->$getterName();
        }else{
          return $this->$propertyName;
        }
      }
      throw new LogicException('Property '.$propertyName.' does not exist.');
    }

    /**
     * @param string $propertyName
     * @param $newValue
     * @return mixed
     */
    public function __set($propertyName, $newValue){
      if (property_exists($this, $propertyName)){
        $setterName='set'.ucfirst($propertyName);
        if (method_exists($this,$setterName)){
          return $this->$setterName($newValue);
        }else{
          return $this->$propertyName=$newValue;
        }
      }
      throw new LogicException('Property '.$propertyName.' does not exist.');
    }

    /**
     * @param string $propertyName
     * @return bool
     */
    public function __isset($propertyName){
      $getterName='get'.ucfirst($propertyName);
      return (property_exists($this, $propertyName) || method_exists($this, $getterName));
    }

    /**
     * @param string $propertyName
     */
    public function __unset($propertyName){
      if (property_exists($this, $propertyName)){
        $this->$propertyName=null;
      }
    }

  }

  /**
   * Class MojeTrida
   * @property float $a;
   * @property float $b
   */
  class MojeTrida{
    use ObjectWithProperties;

    private $a;
    private $b;

    /**
     * @param float $a
     */
    public function setA($a){
      $this->a=$a*2;
    }
  }

  $objekt = new MojeTrida();
  $objekt->a = 10;
  $objekt->b = 20;

  echo $objekt->a + $objekt->b;