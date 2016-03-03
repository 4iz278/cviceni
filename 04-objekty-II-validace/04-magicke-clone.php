<?php

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