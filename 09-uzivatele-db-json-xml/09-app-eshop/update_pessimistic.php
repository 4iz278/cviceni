<?php
  //připojení k databázi
  require 'db.php';

  //přístup jen pro admina
  require 'admin_required.php';

  #region načtení zboží k aktualizaci a výpočet zámku pro pessimistic lock
  //výpočet zámku: ve výsledku máme sloupec edit_expired s boolean hodnotou danou ověřením, jestli již zámek vypršel (tj. jestli je starší než 5 minut)
  $stmt = $db->prepare('SELECT goods.*, users.email, now() > last_edit_starts_at + INTERVAL 5 MINUTE AS edit_expired FROM goods LEFT JOIN users ON users.id=goods.last_edit_starts_by_user WHERE goods.id=:id');
  $stmt->execute([':id'=>@$_REQUEST['id']]);
  $goods = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$goods){
    //pokud zboří neexistuje (např. bylo mezitím smazáno), nepokračujeme dál - i když chyba by určitě mohla být vypsána hezčeji :)
    die("Unable to find goods!");
  }

  $name=$goods['name'];
  $description=$goods['description'];
  $price=$goods['price'];
  #endregion načtení zboží k aktualizaci a výpočet zámku pro pessimistic lock

  #region vyřešení pesimistického zámku pro úpravu
  /*
   * PESIMISTIC LOCK:
   * U zboží kontrolujeme, jestli jej nemá pro úpravu otevřený jiný uživatel.
   * Pokud ano, tak neumožníme pokračovat k editačnímu formuláři.
   * Pokud ne, zboží zamkneme pro úpravu aktuálně přihlášeným uživatele (a znemožníme tak úpravu ostatním).
   *
   * Zámek má časově omezenou platnost - v tomto případě na 5 minut. Pokud zámek vypršel, tak jej ignorujeme.
   * Pokud má zboží zamčené aktuálně přihlášený uživatel, klidně úpravu umožníme - uživatel nemůže zamknout sám sebe.
   */

  if (
    !empty($goods["last_edit_starts_by_user"]) && 								//toto zboží je právě upravováno
    $goods["last_edit_starts_by_user"] != $currentUser['id'] && 	//úpravu provádí jiný než aktuálně přihlášený uživatel
    !$goods['edit_expired'] 																	  //zámek ještě nevypršel
  ){
    //zobrazíme uživateli informaci o tom, kdo zboží aktuálně upravuje
    die("The goods is currently edited by ".$goods['email']);
  }

  //pokud není dané zboží zamčené k úpravě, nebo zámek vypršel, nastavíme zámek nový
  $stmt = $db->prepare("UPDATE goods SET last_edit_starts_at=NOW(), last_edit_starts_by_user=:user WHERE id=:id");
  $stmt->execute([':user'=> $currentUser["id"], ':id'=> $_GET['id']]);
  #endregion vyřešení pesimistického zámku pro úpravu

  if (!empty($_POST)) {
    $formErrors='';

    //TODO tady by měly být nějaké kontroly odeslaných dat, že :)

    $name=$_POST['name'];
    $description=$_POST['description'];
    $price=floatval($_POST['price']);

    if (empty($formErrors)){
      #region uložení zboží do DB
	    //při uložení zboží kromě změněných dat také vynulujeme zámky nastavené pro editaci (aby mohl zboží případně editovat další uživatel)
      $stmt = $db->prepare('UPDATE goods SET name=:name, description=:description, price=:price, last_edit_starts_by_user=NULL, last_edit_starts_at=NULL WHERE id=:id LIMIT 1;');
      $stmt->execute([
        ':name'=> $name,
        ':description'=> $description,
        ':price'=>$price,
        ':id'=> $goods['id']
      ]);
      #endregion uložení zboží do DB

      //přesměrování na homepage
      header('Location: index.php');
      exit();
    }
  }
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>PHP Shopping App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>
	  <?php include 'navbar.php' ?>
	
	  <h1>Update goods</h1>

    <?php
      if (!empty($formErrors)){
        echo '<p style="color:red;">'.$formErrors.'</p>';
      }
    ?>

	<form method="post">
    <label for="name">Name</label><br/>
    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars(@$name);?>" required><br/><br/>

    <label for="price">Price<br/>
    <input type="number" min="0" name="price" id="price" required value="<?php echo htmlspecialchars(@$price)?>"><br/><br/>

    <label for="description">Description</label><br/>
    <textarea name="description" id="description"><?php echo htmlspecialchars(@$description)?></textarea><br/><br/>
				
		<br/>
		
		<input type="hidden" name="id" value="<?php echo $goods['id']; ?>" />
		
		<input type="submit" value="Save" /> or <a href="index.php">Cancel</a>
		
	</form>

</body>

</html>
