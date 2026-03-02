<?php

//obecna kontrola pres php, nekontroluje se format

if (isset($_POST['save'])) {

	$errors = "";
		
	# kontrola na prazdny retezec pres trim	
	if (empty(trim($_POST['firstname']))){
		$errors = "First name can't be blank!<br>";
	}

	if (empty(trim($_POST['lastname']))){
		$errors = $errors."Last name can't be blank!<br>";
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
	if(isset($errors)){
		echo $errors;
	}
	?>
	</div>
	
	<form action="" method="POST" id="myForm">
	  
		First Name:<br/>
		<input type="text" name="firstname" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>"><br/><br/>
	  
		Surname:<br/>
		<input type="text" name="lastname" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>"><br/><br/>
				
	
		<input type="hidden" name="save" value="1">
		
		<input type="submit" value="Submit">
		
	</form>
	
	

	
	
</body>
	
</html>