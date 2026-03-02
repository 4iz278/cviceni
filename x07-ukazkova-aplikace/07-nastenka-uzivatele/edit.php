<?php
  //načteme připojení k databázi a inicializujeme session
  require_once 'inc/user.php';

  if (empty($_SESSION['user_id'])){
    //uživatel není přihlášen
    exit('Pro úpravu příspěvků na nástěnce musíte být přihlášen(a).');
    //TODO zvládli uživateli nějak zobrazit chybovou hlášku a přesměrovat ho na homepage?
  }

  //pomocné proměnné pro přípravu dat do formuláře
  $postId='';
  $postCategory=(!empty($_REQUEST['category'])?intval($_REQUEST['category']):'');
  $postText='';

  #region načtení existujícího příspěvku z DB
  if (!empty($_REQUEST['id'])){
    $postQuery=$db->prepare('SELECT * FROM posts WHERE post_id=:id LIMIT 1;');
    $postQuery->execute([':id'=>$_REQUEST['id']]);
    if ($post=$postQuery->fetch(PDO::FETCH_ASSOC)){
      //naplníme pomocné proměnné daty příspěvku
      $postId=$post['post_id'];
      $postCategory=$post['category_id'];
      $postText=$post['text'];
    }else{
      exit('Příspěvek neexistuje.');//tady by mohl být i lepší výpis chyby :)
    }
  }
  #endregion načtení existujícího příspěvku z DB

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
        $postCategory='';
      }else{
        $postCategory=$_POST['category'];
      }

    }else{
      $errors['category']='Musíte vybrat kategorii.';
    }
    #endregion kontrola kategorie
    #region kontrola textu
    $postText=trim(@$_POST['text']);
    if (empty($postText)){
      $errors['text']='Musíte zadat text příspěvku.';
    }
    #endregion kontrola textu

    if (empty($errors)){
      #region uložení dat

      if ($postId){
        #region aktualizace existujícího příspěvku
        $saveQuery=$db->prepare('UPDATE posts SET category_id=:category, text=:text, user_id=:user WHERE post_id=:id LIMIT 1;');
        $saveQuery->execute([
          ':category'=>$postCategory,
          ':text'=>$postText,
          ':id'=>$postId,
          ':user'=>$_SESSION['user_id']
        ]);
        #endregion aktualizace existujícího příspěvku
      }else{
        #region uložení nového příspěvku
        $saveQuery=$db->prepare('INSERT INTO posts (user_id, category_id, text) VALUES (:user, :category, :text);');
        $saveQuery->execute([
          ':user'=>$_SESSION['user_id'],
          ':category'=>$postCategory,
          ':text'=>$postText
        ]);
        #endregion uložení nového příspěvku
      }

      #endregion uložení dat
      #region přesměrování
        header('Location: index.php?category='.$postCategory);
      exit();
      #endregion přesměrování
    }
    #endregion zpracování formuláře
  }

  //vložíme do stránek hlavičku
  if ($postId){
    $pageTitle='Úprava příspěvku';
  }else{
    $pageTitle='Nový příspěvek';
  }

  include 'inc/header.php';
?>

  <form method="post">
    <input type="hidden" name="id" value="<?php echo $postId;?>" />

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
              echo '<option value="'.$category['category_id'].'" '.($category['category_id']==$postCategory?'selected="selected"':'').'>'.htmlspecialchars($category['name']).'</option>';
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
      <textarea name="text" id="text" required class="form-control <?php echo (!empty($errors['text'])?'is-invalid':''); ?>"><?php echo htmlspecialchars($postText)?></textarea>
      <?php
        if (!empty($errors['text'])){
          echo '<div class="invalid-feedback">'.$errors['text'].'</div>';
        }
      ?>
    </div>

    <button type="submit" class="btn btn-primary">uložit...</button>
    <a href="index.php?category=<?php echo $postCategory;?>" class="btn btn-light">zrušit</a>
  </form>

<?php
  //vložíme do stránek patičku
  include 'inc/footer.php';