<?php

  $soubor = __DIR__.'/03-csv/example.csv';

  if (file_exists($soubor)){
    echo 'Soubor '.$soubor.' existuje.';
  }else{
    echo 'Soubor '.$soubor.' neexistuje.';
  }

  if (is_writable($soubor)){
    echo 'Soubor '.$soubor.' je zapisovatelný.';
  }else{
    echo 'Soubor '.$soubor.' není zapisovatelný.';
  }