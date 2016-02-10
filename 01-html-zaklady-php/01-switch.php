<?php

  $promenna = "b";//definice hodnocené proměnné (vyzkoušejte si ji změnit...)

  switch($promenna){
    case "a":
      echo "větev A byla aktivní\n";
      break; //break ukončí procházení dalších příkazů
    case "b":
      echo "větev B byla aktivní\n"; //pokud tu chybí break, pokračuje kód dál...
    case "c":
      echo "větev C byla aktivní\n";
      break;

  }

  echo " switch byl dokončen";


