<?php
  //načteme připojení k databázi a inicializujeme session
  require_once 'inc/user.php';

  //vložíme do stránek hlavičku
  include __DIR__.'/inc/header.php';

  if (!empty($_SESSION['user_id'])){
    echo '<p>Přihlášený uživatel: <strong>'.htmlspecialchars($_SESSION['user_name']).'</strong></p>';
    echo '<a href="logout.php" class="btn btn-primary">odhlásit se</a>';
  }else{
    echo '<p>Uživatel není přihlášen.</p>';
    echo '<a href="login.php" class="btn btn-primary">přihlásit se</a>';
  }

  //vložíme do stránek patičku
  include __DIR__.'/inc/footer.php';