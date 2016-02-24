<?php

  //načteme celý obsah souboru; při povoleném fopen wrapperu funguje načtení souboru také přes http protokol :)
  $file = file_get_contents('https://github.com/4iz278/cviceni/tree/master/02-retezce-soubory/csv/example.csv');


  file_put_contents('test.txt','testovací zápis'); //vytvoří či přepíše soubor test.txt



  file_put_contents('test.txt','testovací zápis',FILE_APPEND); //připojí zápis na konec souboru