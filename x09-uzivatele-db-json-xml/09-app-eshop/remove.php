<?php
  //připojení k databázi
  require 'db.php';

  //přístup jen pro přihlášeného uživatele
  require 'user_required.php';

  #region nalezení zboží s daným ID a jeho odebrání z košíku
  $id = $_GET['id'];
  foreach ($_SESSION['cart'] as $key => $value){
    if ($value == $id) {
      unset($_SESSION['cart'][$key]);
    }
  }
  //pro zjednodušení nekontrolujeme, jestli opravdu bylo dané zboží v košíku
  #region nalezení zboží s daným ID a jeho odebrání z košíku

  header('Location: cart.php');//přesměrujeme uživatele do košíku
