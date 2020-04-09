<?php

  //načteme připojení k databázi
  require_once 'inc/db.php';

  $errors=[];
  if (!empty($_POST)){
    #region zpracování formuláře
    #region kontrola kategorie
    if (!empty($_POST['category'])){

      $categoryQuery=$db->prepare('SELECT * FROM categories WHERE category_id=:category LIMIT 1;');
      $categoryQuery->execute([
        ':category'=>$_POST['category']
      ]);
      if ($categoryQuery->rowCount()==0){
        $errors['category']='Zvolená kategorie neexistuje!';
        $_POST['category']='';
      }

    }else{
      $errors['category']='Musíte vybrat kategorii.';
    }
    #endregion kontrola kategorie
    #region kontrola textu
    $text=trim(@$_POST['text']);
    if (empty($text)){
      $errors['text']='Musíte zadat text příspěvku.';
    }
    #endregion kontrola textu

    if (empty($errors)){
      #region uložení dat
      $saveQuery=$db->prepare('INSERT INTO posts (user_id, category_id, text) VALUES (:user, :category, :text);');
      $saveQuery->execute([
        ':user'=>1, //zatím uživatele nijak neřešíme (to bude předmětem dalšího cvičení)
        ':category'=>$_POST['category'],
        ':text'=>$text
      ]);
      #endregion uložení dat
      #region přesměrování
      header('Location: index.php');
      exit();
      #endregion přesměrování
    }
    #endregion zpracování formuláře
  }

  //vložíme do stránek hlavičku
  $pageTitle='Nový příspěvek';
  include 'inc/header.php';
?>

  <form method="post">

    <div class="form-group">
      <label for="category">Kategorie:</label>
      <select name="category" id="category" required class="form-control <?php echo (!empty($errors['category'])?'is-invalid':''); ?>">
        <option value="">--vyberte--</option>
        <?php
          $categoryQuery=$db->prepare('SELECT * FROM categories ORDER BY name;');
          $categoryQuery->execute();
          $categories=$categoryQuery->fetchAll(PDO::FETCH_ASSOC);
          if (!empty($categories)){
            foreach ($categories as $category){
              echo '<option value="'.$category['category_id'].'" '.($category['category_id']==@$_POST['category']?'selected="selected"':'').'>'.htmlspecialchars($category['name']).'</option>';
            }
          }
        ?>
      </select>
      <?php
        if (!empty($errors['category'])){
          echo '<div class="invalid-feedback">'.$errors['category'].'</div>';
        }
      ?>
    </div>

    <div class="form-group">
      <label for="text">Text příspěvku:</label>
      <textarea name="text" id="text" required class="form-control <?php echo (!empty($errors['text'])?'is-invalid':''); ?>"><?php echo htmlspecialchars(@$_POST['text'])?></textarea>
      <?php
        if (!empty($errors['text'])){
          echo '<div class="invalid-feedback">'.$errors['text'].'</div>';
        }
      ?>
    </div>

    <button type="submit" class="btn btn-primary">uložit...</button>
    <a href="index.php" class="btn btn-light">zrušit</a>
  </form>

<?php
  //vložíme do stránek patičku
  include 'inc/footer.php';