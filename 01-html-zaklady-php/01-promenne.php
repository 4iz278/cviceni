<?php
  $a = "10";
  $b = 20;

  $c = $a + $b; //sečtení dvou proměnných (s automatickým přetypováním)

  $d = $a . $b; //spojí proměnné jako řetězce

  echo '$c je '.$c.', $d je '.$d;

//----------------------------------------------
  echo "\n";//vypíše nový řádek

  $x = 10;
  $x += 2;//připočte k dané proměnné 2
  $y = 'x';
  echo $$y;//nejprve nahradí $y za její textovou hodnotu a pak pokračuje ve vyhodnocování