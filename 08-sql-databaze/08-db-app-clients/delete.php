<?php

require __DIR__.'/db.php';

if (!empty($_GET['id'])) {
  $stmt = $db->prepare("DELETE FROM clients WHERE id=?");
  $stmt->execute([intval($_GET['id'])]);
}

header('Location: ./');


