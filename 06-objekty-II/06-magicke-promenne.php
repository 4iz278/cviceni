<?php

  /**
   * Class Trida - ukázková třída s magickými metodami pro přístup k proměnným
   */
  class Trida{

    public ?string $a = 'A';
    protected ?string $b = 'B';
    private ?string $c = 'C';

    private array $data=[];

    /**
     * Funkce volaná v případě čtení neexistující či nepřístupné property
     */
    public function __get(string $jmenoPromenne):mixed{
      echo 'cteni property '.$jmenoPromenne.PHP_EOL;//výpisy pomocí echo jsou tu jen pro účel výuky, v reálném kódu byste samozřejmě jen vrátili danou hodnotu

      if (property_exists($this,$jmenoPromenne)){// property_exists zjistí, zda má objekt definovanou danou property (bez ohledu na její viditelnost)
        return $this->$jmenoPromenne;
      }elseif(isset($this->data[$jmenoPromenne])){
        return $this->data[$jmenoPromenne];
      }
      return null;
    }

    /**
     * Funkce volaná v případě přiřazování hodnoty do neexistující či nepřístupné property
     */
    public function __set(string $jmenoPromenne, mixed $hodnota):void{
      echo 'zapis property '.$jmenoPromenne.PHP_EOL;
      var_dump($hodnota);

      if (property_exists($this,$jmenoPromenne)){
        $this->$jmenoPromenne=$hodnota;
      }else{
        $this->data[$jmenoPromenne]=$hodnota;
      }
    }

    /**
     * @param string $jmenoPromenne
     * @return bool
     */
    public function __isset(string $jmenoPromenne):bool{
      echo 'kontrola isset na property '.$jmenoPromenne.PHP_EOL;

      return property_exists($this,$jmenoPromenne) || isset($this->data[$jmenoPromenne]);
    }

    /**
     * @param string $jmenoPromenne
     */
    public function __unset(string $jmenoPromenne):void{
      echo 'unset na property '.$jmenoPromenne.PHP_EOL;

      if(property_exists($this,$jmenoPromenne)) {
        //proměnnou nastavíme na null; pokud bychom zavolali unset($this->$jmenoPromenne), property by byla ve stavu "uninitialized"
        $this->$jmenoPromenne=null;
      }elseif(isset($this->data[$jmenoPromenne])){
        unset($this->data[$jmenoPromenne]);
      }
    }
  }

  $objekt = new Trida();

  echo PHP_EOL.'--'.PHP_EOL;

  $objekt->a = 'testA';
  $objekt->b = 'testB';
  $objekt->c = 'testC';
  $objekt->d = 'testD';

  echo PHP_EOL.'--'.PHP_EOL;

  echo $objekt->a;
  echo $objekt->b;
  echo $objekt->c;
  echo $objekt->d;

  echo PHP_EOL.'--'.PHP_EOL;

  var_dump(isset($objekt->d));
  var_dump(isset($objekt->e));

  echo PHP_EOL.'--'.PHP_EOL;

  unset($objekt->x);