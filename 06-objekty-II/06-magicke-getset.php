<?php
  /*
   * V tomto příkladu najdete ukázku simulace properties á la C# - ve třídě máme proměnné definované jako private a zpřístupněné pomocí magických metod.
   * Pokud máme pro danou proměnnou definovaný getter nebo setter, tak se automaticky zavolá.
   */


  /**
   * Trait ObjectWithProperties - ukázka implementace properties
   */
  trait ObjectWithProperties{
    public function __get(string $propertyName):mixed{
      if (property_exists($this, $propertyName)){
        $getterName='get'.ucfirst($propertyName);
        if (method_exists($this,$getterName)){
          return $this->$getterName();
        }else{
          return $this->$propertyName;
        }
      }
      throw new \LogicException('Property '.$propertyName.' does not exist.');
    }

    public function __set(string $propertyName, mixed $newValue):void{
      if (property_exists($this, $propertyName)){
        $setterName='set'.ucfirst($propertyName);
        if (method_exists($this,$setterName)){
          $this->$setterName($newValue);
        }else{
          $this->$propertyName=$newValue;
        }
        return;
      }
      throw new \LogicException('Property '.$propertyName.' does not exist.');
    }

    /**
     * @param string $propertyName
     * @return bool
     */
    public function __isset(string $propertyName):bool{
      $getterName='get'.ucfirst($propertyName);
      return (property_exists($this, $propertyName) || method_exists($this, $getterName));
    }

    /**
     * @param string $propertyName
     */
    public function __unset(string $propertyName):void{
      if (property_exists($this, $propertyName)){
        $this->$propertyName=null;
      }
    }

  }

  /**
   * Class MojeTrida
   */
  class MojeTrida{
    use ObjectWithProperties; //načíteme příslušný trait

    private ?float $a = null;
    private ?float $b = null;

    /**
     * @param float $a
     */
    public function setA(float $a){
      $this->a=$a*2;
    }
  }

  $objekt = new MojeTrida();
  $objekt->a = 10;
  $objekt->b = 20;

  echo $objekt->a + $objekt->b;