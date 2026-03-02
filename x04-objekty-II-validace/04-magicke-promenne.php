<?php

  /**
   * Class Trida - ukázková třída s magickými metodami pro přístup k proměnným
   */
  class Trida{

    public    $a = 'A';
    protected $b = 'B';
    private   $c = 'C';

    private $data=[];

    /**
     * Funkce volaná v případě čtení neexistující či nepřístupné property
     * @param string $jmenoPromenne
     * @return mixed
     */
    public function __get($jmenoPromenne){
      echo 'cteni property '.$jmenoPromenne.PHP_EOL;//výpisy pomocí echo jsou tu jen pro účel výuky, v reálném kódu byste samozřejmě jen vrátili danou hodnotu

      if (property_exists($this,$jmenoPromenne)){//metoda property_exists umí zjistit, jestli je v daném objektu definována příslušná proměnná (property)
        return $this->$jmenoPromenne;
      }elseif(isset($this->data[$jmenoPromenne])){
        return $this->data[$jmenoPromenne];
      }
      return null;
    }

    /**
     * Funkce volaná v případě přiřazování hodnoty do neexistující či nepřístupné property
     * @param string $jmenoPromenne
     * @param $hodnota
     */
    public function __set($jmenoPromenne, $hodnota){
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
    public function __isset($jmenoPromenne){
      echo 'kontrola isset na property '.$jmenoPromenne.PHP_EOL;

      return property_exists($this,$jmenoPromenne) || isset($this->data[$jmenoPromenne]);
    }

    /**
     * @param string $jmenoPromenne
     */
    public function __unset($jmenoPromenne){
      echo 'usset na property '.$jmenoPromenne.PHP_EOL;

      if(property_exists($this,$jmenoPromenne)) {
        unset($this->$jmenoPromenne);
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

  $x = $objekt->a;
  $x = $objekt->b;
  $x = $objekt->c;
  $x = $objekt->d;

  echo PHP_EOL.'--'.PHP_EOL;

  var_dump(isset($objekt->d));
  var_dump(isset($objekt->e));

  echo PHP_EOL.'--'.PHP_EOL;

  unset($objekt->x);