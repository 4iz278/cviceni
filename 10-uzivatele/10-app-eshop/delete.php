<?php
  //připojení k databázi
  /** @var \PDO $db */
  require __DIR__.'/inc/db.php';

  // přístup jen pro admina
  require __DIR__.'/inc/admin_required.php';

  //odebrání zboží z DB
  //POZOR: i když aplikaci používá admin, musíme počítat s rizikem útoku a použít prepared statement!
  $stmt = $db->prepare("DELETE FROM goods WHERE id=?");
  $stmt->execute([$_GET['id']]);

  //přesměrování na homepage
  header('Location: ./');