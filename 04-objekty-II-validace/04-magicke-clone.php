<?php
  
  /*
   * Za normálních okolností jsou při přiřazení objekty předávány jako reference (tj. obě proměnné poté odkazují na stejné místo v paměti a změny v jedné proměnné se projeví i ve druhé).
   * Pokud chceme objekt jako celek zkopírovat, používáme k tomu přiřazení s klíčovým slovem "clone". Poté je zavolána magická metoda __clone, která může vytvořit kopie (klony) také od vnořených objektů. Proměnné s čísly a řetězci jsou naklonovány automaticky.
   */

  class Trida1{
    public $id;

    public function __construct($id){
      $this->id=$id;
    }

    public function __clone(){
      $this->id.=' - kopie';
    }
  }

  class Trida2{
    public $vnorenyObjekt;
    public $vnorenyObjekt2;

    /**
     * Funkce využívaná při vytváření kopie objektu
     */
    function __clone(){
      //vynutíme kopii vnořeného objektu
      $this->object1 = clone $this->vnorenyObjekt;

      //pokud tu některý z vnořených objektů nenaklonujeme, bude se jednat o referenci na ten samý objekt
    }
  }

  $objekt1=new Trida2();
  $objekt1->vnorenyObjekt = new Trida1('prvni');
  $objekt1->vnorenyObjekt2 = new Trida1('druhy');

  $objekt2 = clone $objekt1; //objekty klonujeme pomocí příkazu clone

  var_dump($objekt1);
  var_dump($objekt2);


  var_dump($objekt1 == $objekt2);//TODO proč tohle porovnání nefunguje? Vždyť jde o klony stejného objektu, ne? :)