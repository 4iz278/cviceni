<?php

require 'db.php';

if (isset($_GET['offset'])) {
	
	$offset = (int)$_GET['offset'];
	
} else {
	
	$offset = 0;
}

$count = $db->query("SELECT COUNT(id) FROM clients")->fetchColumn();

$stmt = $db->prepare("SELECT * FROM clients ORDER BY id DESC LIMIT 10 OFFSET ?");
$stmt->bindValue(1, $offset, PDO::PARAM_INT);
$stmt->execute();
$clients = $stmt->fetchAll();

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
	
	Total rows: <?= $count ?>
	
	<br/><br/>
	
	<table>

		<tr>
		
			<th>First Name</th>
			<th>Last Name</th>
			<th>Salary</th>		
			<th>Note</th>
			<th>Actions</th>			
		
		</tr>
	
		<?php foreach($clients as $row) { ?>

			<tr>
				<td><?= $row['first_name'] ?></td>
				<td><?= $row['last_name'] ?></td>
				<td class="right"><?= $row['salary'] ?></td>
				<td><?= $row['note'] ?></td>
				
				<td class="center">
					<a href='/update.php?id=<?= $row['id'] ?>'>Edit</a> | 
					<a href='/delete.php?id=<?= $row['id'] ?>'>Delete</a>
				</td>
				
			</tr>
		
			<?php } ?>

		</table>
		
		<div class="pagination">	
			<?php for($i=1; $i<=ceil($count/10); $i++) { ?>

				<a class="<?= $offset/10+1==$i ? "active" : ""  ?>" href="index_with_pagination.php?offset=<?= ($i-1)*10 ?>"><?= $i ?></a>
			
				<?php } ?>
			</div>
		
			<br/>
		
			<a href="new_open.php">New Client (Open to SQL Inject Attack)</a><br/><br/>
			<a href="new_escape.php">New Client (Safe, escaped)</a><br/><br/>
			<a href="new_prepare.php">New Client (Safe, prepare)</a><br/><br/>
			<a href="mysql_real_escape_string.php">mysql_real_escape_string function demonstration</a><br/><br/>
			<a href="index_with_pagination.php">index with pagination</a><br/><br/>
			<a href="index.php">index without pagination</a>

		

		</body>

		</html>

