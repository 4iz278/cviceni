<?php

  $file = @fopen('02-csv/example.csv', 'r');//otevření souboru v režimu pro čtení

  if($file){  //kontrola, jestli se podařilo soubor otevřít

    $radek1 = fgets($file); //načte 1 řádek

    $data = fread($file, 30); //načte 30 bytů ze začátku 2. řádku souboru (vhodné pro binární čtení, nenačítá podle konců řádků

    fclose($file);  //zavření daného souboru

  }