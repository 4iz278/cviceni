<?php

  session_start();

  $chyby='';
  if (!empty($_POST)){
    if (empty($_POST['login']) || empty($_POST['password'])){
      $chyby.='Musíte zadat uživatelské jméno a heslo.';
    }
    //tady by mělo být ověření shody s přihlašovacími údaji v DB, ale to zatím neřešíme

    if (empty($chyby)){
      $_SESSION['user']=$_POST['login'];//uložíme jméno uživatele do session
      header('Location: index.php');//přesměrujeme uživatele na index
    }
  }

?><!DOCTYPE html>
<html lang="cs">
  <head>
    <meta charset="UTF-8"/>
    <title>Přihlášení - ukázková aplikace</title>
  </head>
  <body>

    <h1>Přihlášení do ukázkové aplikace</h1>

    <?php
      if (!empty($chyby)){
        echo '<div style="color:red;">'.$chyby.'</div>';
      }
    ?>
    <form method="post">
      <label for="login">Přihlašovací jméno:</label><br />
      <input type="text" name="login" id="login" value="" /><br />
      <label for="password">Heslo:</label><br />
      <input type="password" name="password" id="password" /><br />
      <input type="submit" value="Přihlásit se..." />
    </form>

  </body>
</html>
