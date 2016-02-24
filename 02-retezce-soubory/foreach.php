<?php

#region simple foreach

$arr = ['a','b','c',10=>'d'];
foreach ($arr as $value){ //nejjednodušší varianta projití pole, zajímají nás jen hodnoty
  echo $value;
}

echo "\n\n";

foreach ($arr as $key=>$value){ //procházíme pole, zajímají nás klíče i hodnoty (nebo jen klíče :))
  echo $key.' = '.$value;
}

#endregion simple foreach

#region foreach s kontrolou

$arr = [];
if (!empty($arr)){ //POZOR: u každého foreach cyklu, kde si nejsme jisti, že pole není prázdné, ho musíme nejdřív zkontrolovat!
  foreach ($arr as $value){
    //zpracování...
  }
}

#endregion foreach s kontrolou

#region foreach se zápisem

$arr = ['a','b','c'];
foreach($arr as &$item){ //předání položky referencí (pomocí &)
  if ($item=='a'){
    $item='x';
  }
}

#endregion foreach se zápisem

#region pole s piškvorkami

$piskvorky = [ //jednoduchá definice vícenásobného pole
  ['x','o',''],
  ['o','x',''],
  ['o','o','x'],
];

echo '<table>';
foreach($piskvorky as $radek){
  echo '<tr>';
  foreach ($radek as $bunka){
    echo '<td>'.$bunka.'</td>';
  }
  echo '</tr>';
}
echo '</table>';

#endregion pole s piškvorkami