<?php
# pripojeni do db
require 'db.php';

# pristup jen pro admina
require 'admin_required.php';

$stmt = $db->prepare("SELECT * FROM goods WHERE id=?");
$stmt->execute(array($_GET['id']));
$goods = $stmt->fetch();

if (!$goods){
	die("Unable to find goods!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$stmt = $db->prepare("UPDATE goods SET name=?, description=?, price=? WHERE id=?");
	$stmt->execute(array($_POST['name'], $_POST['description'], (float)$_POST['price'], $_POST['id']));
	
	header('Location: index.php');
	
}

?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>PHP Shopping App</title>
	<link rel="stylesheet" type="text/css" href="/css/styles.css">
</head>

<body>
	
	<?php include 'navbar.php' ?>
	
	<h1>Update goods</h1>

	<form action="" method="POST">
	    
		Name<br/>
		<input type="text" name="name" value="<?= $goods['name'] ?>"><br/><br/>
		
		Price<br/>
		<input type="text" name="price" value="<?= $goods['price'] ?>"><br/><br/>
		
		Description<br/>
		<textarea name="description"><?= $goods['description'] ?></textarea><br/><br/>
				
		<br/>
		
		<input type="hidden" name="id" value="<?= $goods['id'] ?>"> 
		
		<input type="submit" value="Save"> or <a href="/">Cancel</a>
		
	</form>

</body>

</html>
