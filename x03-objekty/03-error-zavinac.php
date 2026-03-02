<?php

  /** Příklad obsahující ukázku ošetření chyby pomocí zavináče */

  include 'nejakySoubor.txt'; //v případě neexistujícího souboru bude vypsána chyba

  @include 'nejakySoubor.txt'; //počítáme s tím, že daná funkce může vyhazovat chybu - a my chceme tu chybu skrýt


  echo @$neexistujiciPromenna;//ošetření přístupu k proměnné, která není definována


  $file = @fopen('x.txt','r'); //skrytí chyby při pokusu o otevření souboru
  if ($file){
    //.....
    fclose($file);
  }


  //alternativní ošetření přístupu k souboru - aby nedocházelo k vyhození chyby
  if (is_file('x.txt') && is_readable('x.txt')){
    $file=fopen('x.txt','r');
    //.....
    fclose($file);
  }
