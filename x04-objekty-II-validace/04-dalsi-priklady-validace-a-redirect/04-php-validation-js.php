<pre>
<?php

//osetreni poli javascriptem pred odeslanim

if (isset($_POST['save'])) {

    var_dump($_POST);
		
}

?>
</pre>


<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>PHP</title>	
</head>

<body>

	<form action="" method="POST" id="myForm" onsubmit="return checkForm();">
	  
		First Name:<br/>
		<input type="text" name="firstname" value="John" placeholder="Your First Name, eg. John" size="30"><br/><br/>
	  
		Surname:<br/>
		<input type="text" name="lastname" value="Smith"><br/><br/>
				
		<br/>
		
		<input type="hidden" name="save" value="1">
		
		<input type="submit" value="Submit">
		
	</form>
	
	
	<script>
	
	function checkForm() {
		
		var form = document.getElementById('myForm').elements;
		var firstname = form.namedItem('firstname').value;
		var lastname = form.namedItem('lastname').value;
		var message = ""
			
		if (firstname == null || firstname == "") {
			message += "First name can't be blank!\n"
		}
		
		if (lastname == null || lastname == "") {
			message += "Lastname name can't be blank!"
		}
		
		if (message != "") {
			alert(message)
			return false;
		}
			
	}
	
	</script>
	
	
	
</body>
	
</html>