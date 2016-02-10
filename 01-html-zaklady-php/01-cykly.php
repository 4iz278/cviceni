<!DOCTYPE html>
<html>
  <head>
    <title>cykly</title>
    <meta charset="utf-8" />
  </head>
  <body>

    <?php

      for ($i=10; $i<=100; $i+=10){
        echo $i.'<br />';
      }

      $x=5;
      while($x >= 3){
        echo 'x='.$x.' ';
        $x=rand(0,10);//funkce rand generuje náhodné číslo z daného rozsahu
      }

      $y=10;
    ?>
    <p>
      <?php
        do{
          echo 'Y bylo '.$y.'<br />';//jednotlivé PHP bloky na sebe navazují
          $y -= 1;
          if ($y%5 == 0){
            break;//pokud je Y dělitelné 5, ukončíme cyklus
          }
        }while($y > 0);
      ?>
    </p>
  </body>
</html>