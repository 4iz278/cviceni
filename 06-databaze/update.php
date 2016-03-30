<?php

require 'db.php';

$stmt = $db->prepare("SELECT * FROM clients WHERE id=?");
$stmt->execute(array($_GET['id']));
$client = $stmt->fetch();

if (!$client){
	die("Unable to find a client");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$id = $_POST['id'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$salary = (float)$_POST['salary'];
	$note = $_POST['note'];
	
	$stmt = $db->prepare("UPDATE clients SET first_name=?, last_name=?, salary=?, note=? WHERE id=?");
	$stmt->execute(array($first_name, $last_name, $salary, $note, $id));
	
	//nebo s named parameters
	//$stmt = $db->prepare("UPDATE clients SET first_name=:first_name, last_name=:last_name, salary=:salary, note=:note WHERE id=:id");
	//$stmt->execute(array(':first_name' => $first_name, ':last_name' => $last_name, ':salary' => $salary, ':note' => $note, ':id' => $id));
	
	header('Location: index.php');
	
	/* SQL INJECT ATTACK NEFUNGUJE
	'); DELETE FROM clients; --
	*/

}

?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>PHP Clients App</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
	
	<h1>Update client</h1>

	<form action="" method="POST">
	  
		First Name<br/>
		<input type="text" name="first_name" value="<?= $client['first_name'] ?>"><br/><br/>
	  
		Last Name<br/>
		<input type="text" name="last_name" value="<?= $client['last_name'] ?>"><br/><br/>
		
		Salary<br/>
		<input type="text" name="salary" value="<?= $client['salary'] ?>"><br/><br/>
		
		Note<br/>
		<textarea name="note"><?= $client['note'] ?></textarea><br/><br/>
				
		<br/>
		
		<input type="hidden" name="id" value="<?= $client['id'] ?>"> 
		
		<input type="submit" value="Save"> or <a href="/">Cancel</a>
		
	</form>

</body>

</html>
