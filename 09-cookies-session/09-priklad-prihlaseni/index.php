<?php
  session_start();//spustíme session

?><!DOCTYPE html>
<html lang="cs">
  <head>
    <meta charset="UTF-8"/>
    <title>Ukázková aplikace</title>
  </head>
  <body>

  <h1>Ukázková aplikace</h1>

  <?php
    if (empty($_SESSION['user'])){
      echo 'uživatel nepřihlášen - <a href="login.php">přihlásit se...</a>';
    }else{
      echo 'přihlášený uživatel: <strong>'.htmlspecialchars($_SESSION['user']).'</strong> - <a href="logout.php">odhlásit se...</a>';
    }
  ?>

  </body>
</html>