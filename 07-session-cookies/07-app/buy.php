<?php
session_start();

require 'db.php';

# session pole pro kosik
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
}

$stmt = $db->prepare("SELECT * FROM goods WHERE id=?");
$stmt->execute(array($_GET['id']));
$goods = $stmt->fetch();

if (!$goods){
	die("Unable to find goods!");
}

# pridame id zbozi do session pole
# TODO neresime, ze od jednoho zbozi muze byt vetsi mnozstvi nez 1, domaci ukol :)
$_SESSION['cart'][] = $goods["id"];

header('Location: cart.php');


?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>PHP Shopping App</title>
	<link rel="stylesheet" type="text/css" href="/styles.css">
</head>

<body>
	

</body>

</html>
