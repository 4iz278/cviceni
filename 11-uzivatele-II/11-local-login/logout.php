<?php
  //načteme připojení k databázi a inicializujeme session
  require_once __DIR__.'/inc/user.php';

  if (!empty($_SESSION['user_id'])){
    //smažeme ze session identifikaci uživatele
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
  }

  //přesměrujeme uživatele na homepage
  header('Location: ./');