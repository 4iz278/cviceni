<?php
# pripojeni do db
require 'db.php';

# pristup jen pro prihlaseneho uzivatele
require 'user_required.php';

# vypocet zamku: sloupec edit_expired je boolean a je true, pokud uz zamek vyprsel (=je starsi vic nez 5 minut)
$stmt = $db->prepare("SELECT goods.*, users.email, now() > last_edit_starts_at + INTERVAL 5 MINUTE AS edit_expired FROM goods LEFT JOIN users ON users.id = goods.last_edit_starts_by_id WHERE goods.id=?");
$stmt->execute(array($_GET['id']));
$goods = $stmt->fetch();

# pokud by zbozi nahodou neexistovalo (treba bylo mezitim v pozadi smazano), nepokracujeme dal
if (!$goods){
	die("Unable to find goods!");
}

# je zaznam zamknuty k uprave?
# pokud ano, nepokracujeme
# pokud je zaznam zamknuty k uprave dele nez 5 minut, pak zamek ignorujeme
# pokud ja sam (prihlaseny uzivatel) edituju zbozi, tak zamek nekontroluj (nemuzu zamknout sam sebe)
	
if ( 
isset($goods["last_edit_starts_by_id"]) && 										# zbozi je prave upravovano
	$goods["last_edit_starts_by_id"] != $current_user['id'] && 	# jinym uzivatelem, nez jsem ja
		!$goods['edit_expired'] 																	# a zacatek upravy jeste neni 5 minut (zamek jeste nevyprsel)
){
		
	die("The goods is currently edited by ".$goods['email']);
		
}

# pokud zaznam neni zamknuty k uprave (nebo zamek vyprsel), nastavime novy zamek
$stmt = $db->prepare("UPDATE goods SET last_edit_starts_at=NOW(), last_edit_starts_by_id=? WHERE id=?");
$stmt->execute(array($current_user["id"], $_GET['id']));


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	# pri ulozeni zbozi vynulujeme zamky a ulozime zmeny
	$stmt = $db->prepare("UPDATE goods SET name=?, description=?, price=?, last_edit_starts_by_id=NULL, last_edit_starts_at=NULL WHERE id=?");
	$stmt->execute(array($_POST['name'], $_POST['description'], (float)$_POST['price'], $_POST['id']));
	
	header('Location: index.php');
	
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
				
		<input type="submit" value="Save"> or <a href="/">Cancel</a>
		
	</form>

</body>

</html>
