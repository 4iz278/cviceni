<?php

require 'db.php';

// http://php.net/manual/en/class.pdo.php
// http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
// http://wiki.hashphp.org/Validation
// http://www.generatedata.com/

?>


<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>PHP Clients App</title>
	
	<link rel="stylesheet" type="text/css" href="styles.css">
	
</head>

<body>
	
	<h1>Listing clients</h1>

	<table>

		<tr>
		
			<th>First Name</th>
			<th>Last Name</th>
			<th>Salary</th>		
			<th>Note</th>
			<th>Actions</th>			
		
		</tr>
	
		<?php foreach($db->query('SELECT * FROM clients ORDER BY id DESC') as $row) { ?>

			<tr>
				<td><?= $row['first_name'] ?></td>
				<td><?= $row['last_name'] ?></td>
				<td class="right"><?= $row['salary'] ?></td>
				<td><?= $row['note'] ?></td>
				
				<td class="center">
					<a href='update.php?id=<?= $row['id'] ?>'>Edit</a> | 
					<a href='delete.php?id=<?= $row['id'] ?>'>Delete</a>
				</td>
				
			</tr>
		
			<?php } ?>

		</table>
		
		<br/>
		
		<a href="new_open.php">New Client (Open to SQL Inject Attack)</a><br/><br/>
		<a href="new_escape.php">New Client (Safe, escaped)</a><br/><br/>
		<a href="new_prepare.php">New Client (Safe, prepare)</a><br/><br/>
		<a href="mysql_escape_string.php">mysql_escape_string function demonstration</a><br/><br/>
		<a href="index_with_pagination.php">index with pagination</a><br/><br/>
		<a href="index.php">index without pagination</a>
		

	</body>

	</html>

