<?php
# pripojeni do db
require 'db.php';

# pristup jen pro prihlaseneho uzivatele
require 'user_required.php';

$stmt = $db->prepare("SELECT * FROM goods WHERE id=?");
$stmt->execute(array($_GET['id']));
$goods = $stmt->fetch();

# pokud by zbozi nahodou neexistovalo (treba bylo mezitim v pozadi smazano), nepokracujeme dal
if (!$goods){
	die("Unable to find goods!");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	# pred ulozenim si vytahneme aktualni cas z db
	# pokud se lisi predany cas z formulare (ktery jsme nacetli na zacatku editace) od casu ulozeneho v db, znamena to, ze zaznam se mezitim v pozadi zmenil (jiny uzivatel provedl update). Mohl jsem to byt i ja sam, pokud jsem treba provedl edit v jinem okne
	# v tom pripade se NEJAK zachovej, treba varuj, nabidni preulozeni, atd.
	# nebo proste umri s hlaskou, ze zaznam byl zmenen

	$stmt = $db->prepare("SELECT last_updated_at FROM goods WHERE id = ?");
	$stmt->execute(array($_POST['id']));
	$current_last_updated_at = $stmt->fetchColumn();
			
	# cas posledni editace v db a zacatek editace nejsou stejne, zaznam se zmenil v pozadi, nedelame update
	# promennou last_updated_at predavame ve formulari jako hidden pole
	if ($_POST['last_updated_at'] != $current_last_updated_at) {
		
		# tady by idealne mel byt navrat na formular s oznacenymi daty, co se zmenilo a nabidnout prepis nebo ponechani dat
		# pro zjednoduseni ted jen umiram
		die ("The goods were updated by someone else in meantime!");
		
	}

	# ok, casy posledni editace zaznamu v DB = predany cas editace z formulare, tzn. zaznam zatim nebyl zmenen
	# muzeme provest update
	# taky aktualizujeme cas posledni aktualizace, at se pri dalsi editaci nacte aktualni
	$stmt = $db->prepare("UPDATE goods SET name=?, description=?, price=?, last_updated_at=now() WHERE id=?");
	$stmt->execute(array($_POST['name'], $_POST['description'], (float)$_POST['price'], $_POST['id']));
	
	header('Location: index.php');
	
}

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
		
		<input type="hidden" name="last_updated_at" value="<?= $goods['last_updated_at'] ?>">
		
		<input type="submit" value="Save"> or <a href="index.php">Cancel</a>
		
	</form>

</body>

</html>
