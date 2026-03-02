<?php
  //spustíme session
  session_start();

  //připojení k databázi
  require 'db.php';
	
  if (!empty($_POST)) {
	
    $email = @$_POST['email'];
    $password = @$_POST['password'];
	
  	//TODO tady chybí ověření vyplnění dosud neregistrovaného e-mailu a hesla - zvládli byste to doplnit?

	  $passwordHash = password_hash($password, PASSWORD_DEFAULT); //pokud nemáte důvod to měnit, nechte heslo zahashovat výchozí funkcí; další možnosti viz manuál
	
    //uložíme uživatele do DB
    $stmt = $db->prepare("INSERT INTO users(email, password) VALUES (?, ?)");
    $stmt->execute([$email, $passwordHash]);
	
    //teď je uživatel uložen v DB - potřebujeme jeho id
    //buď můžeme vzit id posledního záznamu přes last insert id, ale co když se to potká s více requesty? = ne zcela bezpečné
    //lepší je načíst uživatele podle e-mailu = OK :)
	
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1"); //limit 1 jen tu jen jako výkonnostní optimalizace
    $stmt->execute([$email]);
    //uživatele rovnou přihlásíme
    $_SESSION['user_id'] = (int)$stmt->fetchColumn();

	  //přesměrujeme uživatele na homepage
  	header('Location: index.php');
  }

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>PHP Shopping App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>
	
		<h1>PHP Shopping App</h1>

		<h2>New Signup</h2>
	
		<form method="post">
      <label for="email">Your Email</label><br/>
			<input type="text" name="email" id="email" required value="<?php echo htmlspecialchars(@$_POST['email']);?>"><br/><br/>
	  
      <label for="password">New Password</label><br/><!--POZOR: heslo nikdy nepředvyplňujeme!-->
			<input type="password" name="password" id="password" required value=""><br/><br/>

      <!--TODO tady by bylo vhodné další pole pro potvrzení správnosti hesla -->
	
			<input type="submit" value="Create Account"> or <a href="index.php">Cancel</a>
		</form>
	
  </body>
</html>
