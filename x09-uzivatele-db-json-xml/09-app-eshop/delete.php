<?php
  //připojení k databázi
  require 'db.php';

  // přístup jen pro admina
  require 'admin_required.php';

  //odebrání zboží z DB
  //POZOR: i když aplikaci používá admin, musíme počítat s rizikem útoku a použít prepared statement!
  $stmt = $db->prepare("DELETE FROM goods WHERE id=?");
  $stmt->execute([$_GET['id']]);

  //přesměrování na homepage
  header('Location: index.php');