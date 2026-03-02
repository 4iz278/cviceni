<?php

  $file = @fopen('example.csv', 'r');//otevření souboru

  if($file){  //kontrola, jestli se podařilo soubor otevřít

    while (!feof($file)){
      $radek = fgetcsv($file,null,';'); //načteme řádek tabulky, přičemž je možné definovat, jak jsou jednotlivé buňky odděleny
      //zpracování daného řádku (jedná se o pole)...
    }

    fclose($file);  //zavření daného souboru

  }


  //TODO: zkuste tento příklad upravit tak, aby byla data z daného souboru vypsána v podobě HTML tabulky