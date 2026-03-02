<?php
  //připojení k databázi
  require 'db.php';

  //přístup jen pro admina
  require 'admin_required.php';

  #region načtení zboží k aktualizaci
  $stmt = $db->prepare('SELECT * FROM goods WHERE id=:id');
  $stmt->execute([':id'=>@$_REQUEST['id']]);
  $goods = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$goods){
    die("Unable to find goods!");
  }

  $name=$goods['name'];
  $description=$goods['description'];
  $price=$goods['price'];
  #endregion načtení zboží k aktualizaci

  if (!empty($_POST)) {
    $formErrors='';

    //TODO tady by měly být nějaké kontroly odeslaných dat, že :)

    $name=$_POST['name'];
    $description=$_POST['description'];
    $price=floatval($_POST['price']);


    if (empty($formErrors)){
      #region uložení zboží do DB
      $stmt = $db->prepare('UPDATE goods SET name=:name, description=:description, price=:price WHERE id=:id LIMIT 1;');
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
