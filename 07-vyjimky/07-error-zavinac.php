<?php

/** Příklad obsahující ukázku ošetření chyby pomocí zavináče */

// pokud soubor neexistuje, PHP vypíše varování
include 'nejakySoubor.txt';

// potlačení výpisu chyby pomocí operátoru @
@include 'nejakySoubor.txt';

// potlačení chyby při přístupu k nedefinované proměnné
echo @$neexistujiciPromenna;


// pokus o otevření souboru – potlačení chyby
$file = @fopen('x.txt', 'r');
if ($file) {
  // práce se souborem
  fclose($file);
}


// lepší řešení – předem ověřit existenci a čitelnost souboru
if (is_file('x.txt') && is_readable('x.txt')) {
  $file = fopen('x.txt', 'r');
  // práce se souborem
  fclose($file);
}