<?php

  #region ukázka řazení pole podle vlastní porovnávací funkce (pojmenované)

  /**
   * Funkce pro seřazení položek podle hodnot
   * @param float $a
   * @param float $b
   * @return int - 0 = hodnoty jsou stejné, -1 = $a<$b, -2 = $a>$b
   */
  function mojeRazeni($a,$b) {
    if ($a==$b){
      return 0;
    }elseif($a<$b){
      return -1;
    }else{
      return 1;
    }
  }

  $arr=array("a"=>4,"b"=>2,"c"=>8,"d"=>"6");
  uasort($arr,"mojeRazeni");  //funkce uasort použije pro seřazení pole námi definovanou funkci (se zadaným názvem)

  var_dump($arr);

  #endregion ukázka řazení pole podle vlastní porovnávací funkce


  #region ukázka seřazení položek dle hodnoty z vnořeného pole, anonymní funkce
  $arr = [
    [
      'jmeno'=>'Adam',
      'vek'=>23
    ],
    [
      'jmeno'=>'Eva',
      'vek'=>19
    ],
    [
      'jmeno'=>'Silvestr',
      'vek'=>20
    ]
  ];

  usort($arr, function($a, $b){ //definujeme anonymní funkci, která seřadí lidi podle věku
    return $a['vek']-$b['vek'];  //TODO proč tu stačí mít jeden výpočet místo sady porovnávacích podmínek?
  });

  //TODO jaký je rozdíl v použití funkce usort() a uasort()?

  var_dump($arr);

  #endregion ukázka seřazení položek dle hodnoty z vnořeného pole, anonymní funkce