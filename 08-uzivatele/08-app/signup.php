<?php

session_start();

require 'db.php';
	
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	# TODO PRO STUDENTY osetrit vstupy, email a heslo jsou povinne, atd.
	# TODO PRO STUDENTY jde se prihlasit prazdnym heslem, jen prototyp, pouzit filtry

	# $password = md5($_POST['password']); #chybi salt
	
	# $password = hash("sha256" , $password); #chybi salt
	
	# viz http://php.net/manual/en/function.password-hash.php
	# salt lze generovat rucne (nedoporuceno), nebo to nechat na php, ktere salt rovnou pridat do hashovaneho hesla
	
	/**
	 * We just want to hash our password using the current DEFAULT algorithm.
	 * This is presently BCRYPT, and will produce a 60 character result.
	 *
	 * Beware that DEFAULT may change over time, so you would want to prepare
	 * By allowing your storage to expand past 60 characters (255 would be good)
	 */
	# dalsi moznosti je vynutit bcrypt: PASSWORD_BCRYPT
	$hashed = password_hash($password, PASSWORD_DEFAULT);
	
	#vlozime usera do databaze
	$stmt = $db->prepare("INSERT INTO users(email, password) VALUES (?, ?)");
	$stmt->execute(array($email, $hashed));
	
	#ted je uzivatel ulozen, bud muzeme vzit id posledniho zaznamu pres last insert id (co kdyz se to potka s vice requesty = nebezpecne), nebo nacist uzivatele podle mailove adresy (ok, bezpecne)
	
	$stmt = $db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1"); //limit 1 jen jako vykonnostni optimalizace, 2 stejne maily se v db nepotkaji
	$stmt->execute(array($email));
	$user_id = (int)$stmt->fetchColumn();
			
	$_SESSION['user_id'] = $user_id;
		
	header('Location: index.php');
	
}

?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>PHP Shopping App</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
	
		<h1>PHP Shopping App</h1>

		<h2>New Signup</h2>
	
		<form action="" method="POST">
	  
			Your Email<br/>
			<input type="text" name="email" value=""><br/><br/>
	  
			New Password<br/>
			<input type="password" name="password" value=""><br/><br/>
						
	
			<input type="submit" value="Create Account"> or <a href="/index.php">Cancel</a>
		
		</form>
	
</body>

</html>
