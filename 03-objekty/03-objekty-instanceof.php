<?php

  interface MojeRozhrani{
    //obsah definice rozhraní...
  }

  class TridaX implements  MojeRozhrani{
    //obsah definice třídy...
  }

  class MojeTrida extends TridaX{
    //obsah definice třídy...
  }

  $objekt1 = new TridaX();
  $objekt2 = new MojeTrida();

  if ($objekt1 instanceof MojeRozhrani){
    echo 'objekt1 implementuje MojeRozhrani'.PHP_EOL;
  }

  if ($objekt1 instanceof TridaX){
    echo 'objekt1 je instancí třídy TridaX'.PHP_EOL;
  }

  if ($objekt2 instanceof TridaX){
    echo 'objekt2 je instancí třídy TridaX'.PHP_EOL;
  }

  var_dump( class_parents($objekt2) );       //funkce class_parents vrací pole rodičovských tříd
  var_dump( class_implements($objekt2) );    //funkce class_implements vrací pole implementovaných rozhraní
  var_dump( class_implements("MojeTrida") );

  var_dump( get_class($objekt1) ); //funkce get_class vrací název třídy daného objektu