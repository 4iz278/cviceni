<?php

  $a = 1;
  $b = 2;
  $c = '1';

  if ($a == 1){
    echo '$a je 1';
  }elseif($a == 2){
    echo '$a je 2';
  }else{
    echo '$a je jiné';
  }

  echo "\n";

  if ($a==1 && $b==2){//složená podmínka se spojkou AND
    echo '$a==1 a $b==2'."\n";
  }

  if ($a === $c){ //porovnání s kontrolou datového typu
    echo '$a je stejné jako $c';
  }else{
    echo '$a není stejné jako $c';
  }

  if (!empty($d)){//podmínka s negací, funkce empty() kontroluje, zda je daná proměnná definována a není prázdná
    echo '$d není prázdná';
  }

  echo "\n";

  echo 'zkrácená podmínka '.($c==1 ? 'splněna' : 'nesplněna');//ukázka inline podmínky

  if ($a=1){
    //TODO proč bude tato podmínka vždy splněna?
  }