<?php

  /**
   * Funkce pro součet 2 čísel
   * @param float $a
   * @param float $b
   * @return float
   */
  function suma($a, $b){
    return $a+$b;
  }

  /**
   * Funcke vypisující spojené řetězce
   * @param string $a
   * @param string $b = "x" - volitelný atribut, pokud ho nezadáme, použije se výchozí hodnota
   */
  function spojeniRetezcu($a, $b="x"){
    echo $a.' '.$b;
  }


  /**
   * Ukázka funkce s parametrem předávaným referencí
   * @param &$param - parametr, který je možné modifikovat v rámci těla funkce
   * @param $param2 - parametr, který není možné modifikovat v rámci těla funkce
   */
  function testovaciFunkce(&$param, $param2){
    $param="hodnota";
  }

  //ukázka zavolání funkce
  echo 'suma je '.suma(10,20);