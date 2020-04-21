<?php
  //připojení k databázi
  require 'db.php';

  //přístup jen pro admina
  require 'admin_required.php';
	
  if (!empty($_POST)){
    $formErrors='';

    //TODO tady by měly být nějaké kontroly odeslaných dat, že :)

    if (empty($formErrors)){
      #region uložení zboží do DB
      $stmt = $db->prepare("INSERT INTO goods(name, description, price) VALUES (:name, :description, :price)");
      $stmt->execute([
        ':name'=>$_POST['name'],
        ':description'=>$_POST['description'],
        ':price'=>floatval($_POST['price'])
      ]);
      #endregion uložení zboží do DB
    }

    //přesměrování na homepage
    header('Location: index.php');
    exit();
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
	
	  <h1>New goods</h1>
	
    <?php
      if (!empty($formErrors)){
        echo '<p style="color:red;">'.$formErrors.'</p>';
      }
    ?>

    <form method="post">
      <label for="name">Name</label><br/>
      <input type="text" name="name" id="name" value="<?php echo htmlspecialchars(@$_POST['name']);?>" required><br/><br/>

      <label for="price">Price<br/>
      <input type="number" min="0" name="price" id="price" required value="<?php echo htmlspecialchars(@$_POST['price'])?>"><br/><br/>

      <label for="description">Description</label><br/>
      <textarea name="description" id="description"><?php echo htmlspecialchars(@$_POST['description'])?></textarea><br/><br/>

      <br/>

      <input type="submit" value="Save"> or <a href="index.php">Cancel</a>
    </form>

  </body>
</html>
