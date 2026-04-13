<?php
  /** @var \PDO $db */
  require __DIR__.'/inc/db.php'; //připojíme se k databázi

  $stmt = $db->prepare("DELETE FROM goods WHERE id=?"); //odstraníme zboží z aplikace (pozor, i když teoreticky očekáváme číslo, použijeme prepared statement)
  $stmt->execute(array($_GET['id']));

  header('Location: ./');
