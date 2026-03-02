<?php
  //připojení k DB
  require 'db.php';

  //přístup jen pro přihlášeného uživatele
  require 'user_required.php';

  // session pole pro košík (pokud v košíku nic není, definujeme jej jako prázdné pole)
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }

  //načteme dané zboží z DB - POZOR: ačkoliv očekáváme, že id zboží bude číslo, musíme počítat s rizikem, že se uživatel ve svém požadavku pokusí o sql injection!
  $stmt = $db->prepare("SELECT * FROM goods WHERE id=?");
  $stmt->execute([$_GET['id']]);
  $goods = $stmt->fetch();

  if (!$goods){
    die("Unable to find goods!");
  }

  // pridame id zbozi do session pole (aktuálně můžeme mít v košíku jen 1 kus od každého zboží - ale to už vyřešit umíme, bylo to za domácí úkol)
  $_SESSION['cart'][] = $goods["id"];

  header('Location: cart.php');
