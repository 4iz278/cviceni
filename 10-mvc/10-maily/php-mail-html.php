<?php

//odeslani HTML mailu pres php

if (isset($_POST['save'])) {

	# http://php.net/manual/en/function.mail.php
	# SMTP auth, v php.ini: https://support.google.com/a/answer/176600?hl=cs

	$errors = "";
		
	if (!filter_var($_POST['to'], FILTER_VALIDATE_EMAIL)) {
		$errors = "To is invalid email!<br>";
	}

	if (empty($_POST['subject'])){
		$errors = $errors."Subject can't be blank!<br>";
	}
	
	if (empty($_POST['message'])){
		$errors = $errors."Message can't be blank!<br>";
	}
	
	if (!$errors){
		header('Location: sent.php');		
	}

	$to      = $_POST['to'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	
	
	$html = "
	<html>
	<head>
	  <title>Birthday Reminders for August</title>
	</head>
	<body>
	 
	 $message
	 
	</body>
	</html>
	";
	

	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-type: text/html; charset=UTF-8"; #pozor, musime mit text/html
	$headers[] = "From: Jiri Hradil <jiri@hradil.cz>";
	$headers[] = "Bcc: Blind Copy Recipient <fantomas@hradil.cz>";
	$headers[] = "Reply-To: Jiri Hradil <jiri@hradil.cz>";

	mail($to, $subject, $html, implode("\r\n", $headers));

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
		if (isset($errors)){
			echo $errors;
		}
		?>
	</div>
	
	<form action="" method="POST" id="myForm">
	  
		To:<br/>
		<input type="text" name="to" value="<?php if (isset($_POST['to'])){echo $_POST['to'];} ?>"><br/><br/>
		
		Subject:<br/>
		<input type="text" name="subject" value="<?php if (isset($_POST['subject'])){echo $_POST['subject'];} ?>"><br/><br/>
	  
		Message:<br/>
		<textarea name="message"><?php if (isset($_POST['message'])){echo $_POST['message'];} ?></textarea><br/><br/>
				
	
			<input type="hidden" name="save" value="1">
		
			<input type="submit" value="Submit">
		
		</form>
	
	

	
	
	</body>
	
	</html>



