<?php

require 'db.php';

$stmt = $db->prepare("DELETE FROM clients WHERE id=?");
$stmt->execute(array($_GET['id']));

header('Location: index.php');


