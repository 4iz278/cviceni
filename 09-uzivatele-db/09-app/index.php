<?php
# pripojeni do db
require 'db.php';

# pristup jen pro prihlaseneho uzivatele
require 'user_required.php';

// http://php.net/manual/en/session.examples.basic.php
// Sessions can be started manually using the session_start() function. If the session.auto_start directive is set to 1, a session will automatically start on request startup.

// http://stackoverflow.com/questions/4649907/maximum-size-of-a-php-session
// You can store as much data as you like within in sessions. All sessions are stored on the server. The only limits you can reach is the maximum memory a script can consume at one time, which by default is 128MB.

//http://stackoverflow.com/questions/217420/ideal-php-session-size

# offset pro strankovani
if (isset($_GET['offset'])) {
	$offset = (int)$_GET['offset'];
} else {
	$offset = 0;
}

# celkovy pocet zbozi pro strankovani
$count = $db->query("SELECT COUNT(id) FROM goods")->fetchColumn();

$stmt = $db->prepare("SELECT * FROM goods ORDER BY id DESC LIMIT 10 OFFSET ?");
$stmt->bindValue(1, $offset, PDO::PARAM_INT);
$stmt->execute();
$clients = $stmt->fetchAll();

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
	
	<h1>Goods we've got</h1>
	
	Total goods: <?= $count ?>
	
	<br/><br/>
	
	<a href="new.php">New Good</a>
	
	<br/><br/>
	
	<table>

		<tr>
		
			<th></th>			
			<th>Name</th>
			<th>Price</th>
			<th>Description</th>
			<th></th>			
			
		
		</tr>
	
		<?php foreach($clients as $row) { ?>

			<tr>
				<td class="center">
					<a href='buy.php?id=<?= $row['id'] ?>'>Buy</a>
				</td>
				
				<td><?= $row['name'] ?></td>
				<td class="right"><?= $row['price'] ?></td>
				<td><?= $row['description'] ?></td>
				
				<td class="center" nowrap>
					<a href='update_optimistic.php?id=<?= $row['id'] ?>'>Edit (optimistic lock)</a><br>
					<a href='update_pessimistic.php?id=<?= $row['id'] ?>'>Edit (pessimistic lock)</a><br>
					<a href='delete.php?id=<?= $row['id'] ?>'>Delete</a>
				</td>
				
			</tr>
		
			<?php } ?>

		</table>
		
		<br/>
		
		<div class="pagination">	
			<?php for($i=1; $i<=ceil($count/10); $i++) { ?>

				<a class="<?= $offset/10+1==$i ? "active" : ""  ?>" href="index.php?offset=<?= ($i-1)*10 ?>"><?= $i ?></a>
			
				<?php } ?>
			</div>
		
			<br/>

		</body>

		</html>

