<?php
# pripojeni do db
require 'db.php';

# pristup jen pro admina
require 'admin_required.php';

$stmt = $db->prepare("DELETE FROM goods WHERE id=?");
$stmt->execute(array($_GET['id']));

header('Location: index.php');

?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>PHP Shopping App</title>
	<link rel="stylesheet" type="text/css" href="/css/styles.css">
</head>

<body>

</body>

</html>
