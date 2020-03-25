<?php
  require 'db.php';//připojíme se k databázi

  $stmt = $db->prepare("SELECT * FROM goods WHERE id=?");//zkontrolujeme, zda se uživatel snaží upravit zboží, které opravdu existuje
  $stmt->execute(array($_GET['id']));
  $goods = $stmt->fetch();

  if (!$goods){
    die("Unable to find goods!");//TODO místo "umření" stránky by tu asi bylo hezké zobrazit nějaké varování a umožnit uživateli normálně pokračovat např. výpisem zboží
  }

  if ($_SERVER["REQUEST_METHOD"]=="POST") {//kontrolujeme, jestli byl požadavek poslán metodou POST

    //TODO tadz by asi měly být nějaké kontroly ;)

    $stmt = $db->prepare("UPDATE goods SET name=?, description=?, price=? WHERE id=? LIMIT 1;");//prepared statement pro uložení dat (tentokrát s anonymními parametry)
    $stmt->execute(array($_POST['name'], $_POST['description'], (float)$_POST['price'], $_POST['id']));//naplnění předchozího statementu daty

    header('Location: index.php');//přesměrujeme uživatele na homepage (při přesměrování už se nic dalšího nevykreslí)
  }
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Update goods - PHP Shopping App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>

    <?php include 'navbar.php' ?>
  
    <h1>Update goods</h1>

    <form  method="post"><!--formulář pro zadání zboží do e-shopu - pro zjednodušení bez formátovacích značek-->
      <label for="name">Name</label><br/>
      <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($goods['name']); ?>"><br/><br/>

      <label for="price">Price</label><br/>
      <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($goods['price']); ?>"><br/><br/>

      <label for="description">Description</label><br/>
      <textarea name="description" id="description"><?php echo htmlspecialchars($goods['description']); ?></textarea><br/><br/>

      <input type="hidden" name="id" value="<?php echo htmlspecialchars($goods['id']); ?>"><!--ID zboží si pošleme v hidden poli - uživatele bychom neměli otravovat zbytečným zobrazováním IDček a rozhodně by je neměl zadávat ručně!-->

      <input type="submit" value="Save"> or <a href="./">Cancel</a><!--kromě odesílacího tlačítka je vhodné umožnit také odejít z formuláře bez jeho odeslání-->
    </form>

  </body>
</html>
