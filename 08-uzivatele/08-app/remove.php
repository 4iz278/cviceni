<?php
# pripojeni do db
require 'db.php';

# pristup jen pro prihlaseneho uzivatele
require 'user_required.php';

# zrusime id zbozi ze session
# nekontrolujeme, jestli tam je

$id = $_GET['id'];

#var_dump($_SESSION['cart']);

foreach ($_SESSION['cart'] as $key => $value){
    if ($value == $id) {
				unset($_SESSION['cart'][$key]);
    }
}

header('Location: cart.php');


?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>PHP Shopping App</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
	

</body>

</html>
