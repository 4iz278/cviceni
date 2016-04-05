<?php

require 'db.php';

$name = $_COOKIE['name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	# pokud nenastavime platnost, tak je cookie platna jen pro tuto session
	#setcookie("name", $_POST['name']);
	
	# platnost cookie bude 1 hodina od ulozeni
	# pozor, neni to bezpecne, cookie se v klidu precist a zmenit!
	# cookie je soucasti HTTP hlavicky, takze ji musime nastavit jeste PREDTIM, nez neco posleme na vystup (at uz redirect nebo nejaky text, html, apod.)
	setcookie("name", $_POST['name'], time()+3600); # ted + 3600 sekund = 1 hodina

	header('Location: index.php');
	
}

?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>PHP Shopping App</title>
	<link rel="stylesheet" type="text/css" href="/styles.css">
</head>

<body>
	
	<?php include 'navbar.php' ?>
		
	<h1>About me</h1>

	<form action="" method="POST">
	    
		My Name<br/>
		<input type="text" name="name" value="<?= $name ?>"><br/><br/>
		
		<input type="submit" value="Save"> or <a href="/">Cancel</a>
		
	</form>

</body>

</html>
