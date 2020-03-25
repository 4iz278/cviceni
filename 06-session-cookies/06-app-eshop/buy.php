<?php
  session_start();

  require 'db.php';

  #region vytvoření session pole pro košík
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }
  #endregion vytvoření session pole pro košík

  #region kontrola, jestli je zboží v DB
  $stmt = $db->prepare("SELECT * FROM goods WHERE id=?");
  $stmt->execute(array($_GET['id']));
  $goods = $stmt->fetch();

  if (!$goods){
    die("Unable to find goods!");//TODO místo ukočení skriptu by tu bylo hezké jen nějaké uložení chybové hlášky
  }
  #endregion kontrola, jestli je zboží v DB

  $_SESSION['cart'][] = $goods["id"];//přidání ID zboží do košíku
  //TODO neresime, ze od jednoho zbozi muze byt vetsi mnozstvi nez 1, domaci ukol :)

  header('Location: cart.php');//přesměrujeme uživatele na košík
