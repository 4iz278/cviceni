<?php

//validace mailu a url pres php, musime delat vzdy, nelze spolehat na javascript nebo html!

if (isset($_POST['save'])) {
	
	$errors = "";
		
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$errors = "Email is invalid!<br>";
	}

	if (!filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
		$errors = $errors."URL is invalid!<br>";
	}
	
	if (!$errors){
		header('Location: output.php');		
	}
		
}

?>


<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>PHP</title>	
</head>

<body>
	
	<div style="color: red">
	<?php
	echo $errors;
	?>
	</div>
	
	<form action="" method="POST" id="myForm">
	  
		Email:<br/>
		<input type="text" name="email" value="<?php echo $_POST['email'] ?>"><br/><br/>
	  
		URL:<br/>
		<input type="text" name="url" value="<?php echo $_POST['url'] ?>"><br/><br/>
				
	
		<input type="hidden" name="save" value="1">
		
		<input type="submit" value="Submit">
		
	</form>
	
	

	
	
</body>
	
</html>