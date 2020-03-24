<?php

  session_start(); //spuštění session

  if (!isset($_SESSION['pocetNavstev'])){//ověříme, jestli už je v session naše proměnná a zvětšíme její hodnotu o 1
    $_SESSION['pocetNavstev']=1;
  }else{
    $_SESSION['pocetNavstev']++;
  }

?><!DOCTYPE html>
<html lang="cs">
  <head>
    <meta charset="UTF-8">
    <title>Počítadlo přístupů</title>
  </head>
  <body>

  Tohle je <?php echo $_SESSION['pocetNavstev']; ?>. návštěva této stránky.

  </body>
</html>