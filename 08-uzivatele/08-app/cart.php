<?php
# pripojeni do db
require 'db.php';

# pristup jen pro prihlaseneho uzivatele
require 'user_required.php';

$ids = $_SESSION['cart'];

if (is_array($ids) && count($ids)>0) {

	# retezec s otazniky pro predani seznamu ids	
	# pocet otazniku = pocet prvku v poli ids
	# pokud mam treba v ids 1,2,3, vrati mi ?,?,?	
	$question_marks = str_repeat('?,', count($ids) - 1) . '?';
	
	$stmt = $db->prepare("SELECT * FROM goods WHERE id IN ($question_marks) ORDER BY name");
	# array values - setrepeme pole aby bylo indexovane od 0, jen kvuli dotazu, jinak neprojde
	$stmt->execute(array_values($ids));
	$goods = $stmt->fetchAll();
	
	
	$stmt_sum = $db->prepare("SELECT SUM(price) FROM goods WHERE id IN ($question_marks)");
	# array values - setrepeme pole aby bylo indexovane od 0, jen kvuli dotazu, jinak neprojde
	$stmt_sum->execute(array_values($ids));
	$sum = $stmt_sum->fetchColumn();
	
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
		
	<h1>My shopping cart</h1>
	
	Total goods selected: <?= count($goods) ?>
	
	<br/><br/>
	
 <a href="index.php">Back to the goods</a>
	
	<br/><br/>

	<?php if($goods) { ?>

		
		<table>

			<tr>
		
				<th></th>			
				<th>Name</th>
				<th>Price</th>
				<th>Description</th>			
		
			</tr>
			
			<tfoot>
				
				<tr>
		
					<th>SUM</th>			
					<th></th>
					<th class="right"><?= $sum ?></th>
					<th></th>			
		
				</tr>
			</tfoot>
			
	
			<?php foreach($goods as $row) { ?>

				<tr>
					<td class="center">
						<a href='remove.php?id=<?= $row['id'] ?>'>Remove</a>
					</td>
				
					<td><?= $row['name'] ?></td>
					<td class="right"><?= $row['price'] ?></td>
					<td><?= $row['description'] ?></td>
							
				</tr>
		
				<?php } ?>

			</table>
		
		
		

			<?php } else { ?>
				No goods yet
				<?php } ?>

			</body>

			</html>
