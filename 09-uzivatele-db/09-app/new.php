<?php
# pripojeni do db
require 'db.php';

# pristup jen pro prihlaseneho uzivatele
require 'user_required.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$stmt = $db->prepare("INSERT INTO goods(name, description, price) VALUES (?, ?, ?)");
	$stmt->execute(array($_POST['name'], $_POST['description'], (float)$_POST['price']));
		
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
	
	<?php include 'navbar.php' ?>
	
	<h1>New goods</h1>
	

	<form action="" method="POST">
	  
		Name<br/>
		<input type="text" name="name" value=""><br/><br/>
	  
		Price<br/>
		<input type="text" name="price" value=""><br/><br/>
			
		Description<br/>
		<textarea name="description"></textarea><br/><br/>
				
		<br/>
		
		<input type="submit" value="Save"> or <a href="index.php">Cancel</a>
		
	</form>

</body>

</html>
