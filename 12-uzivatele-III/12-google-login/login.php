<?php
  //načteme připojení k databázi a inicializujeme session
  /** @var \PDO $db */
  require_once __DIR__.'/inc/user.php';

  if (!empty($_SESSION['user_id'])){
    //uživatel už je přihlášený, nemá smysl, aby se přihlašoval znovu
    header('Location: ./');
    exit();
  }

  $errors=false;
  if (!empty($_POST)) {
    #region zpracování formuláře
    $userQuery=$db->prepare('SELECT * FROM users WHERE email=:email LIMIT 1;');
    $userQuery->execute([
                          ':email'=>trim($_POST['email'])
                        ]);
    if ($user=$userQuery->fetch(PDO::FETCH_ASSOC)){

      if (password_verify($_POST['password'],$user['password'])){
        //heslo je platné => přihlásíme uživatele
        session_regenerate_id();
        $_SESSION['user_id']=$user['user_id'];
        $_SESSION['user_name']=$user['name'];

        //doplníme kontrolní smyčku na možné přehashování hesla
        if (password_needs_rehash($user['password'],PASSWORD_DEFAULT)){
          $updateUserQuery=$db->prepare('UPDATE users SET password=:password WHERE user_id=:user_id;');
          $updateUserQuery->execute([
              ':password'=>password_hash($_POST['password'],PASSWORD_DEFAULT),
          ]);
        }

        //smažeme požadavky na obnovu hesla
        $forgottenDeleteQuery=$db->prepare('DELETE FROM forgotten_passwords WHERE user_id=:user;');
        $forgottenDeleteQuery->execute([':user'=>$user['user_id']]);

        //přesměrování na homepage
        header('Location: ./');
        exit();

      }else{
        $errors=true;
      }

    }else{
      $errors=true;
    }
    #endregion zpracování formuláře
  }


  //vložíme do stránek hlavičku
  include __DIR__.'/inc/header.php';
?>

  <h2>Přihlášení uživatele</h2>
  <form method="post">
    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="email" name="email" id="email" required class="form-control <?php echo ($errors?'is-invalid':''); ?>"
             value="<?php echo htmlspecialchars($_POST['email'] ?? '');?>"/>
      <?php
        echo ($errors?'<div class="invalid-feedback">Neplatná kombinace přihlašovacího e-mailu a hesla.</div>':'');
      ?>
    </div>
    <div class="form-group">
      <label for="password">Heslo:</label>
      <input type="password" name="password" id="password" required class="form-control" />
    </div>
    <button type="submit" class="btn btn-primary">přihlásit se</button>
    <a href="forgotten-password.php" class="btn btn-light">zapomněl(a) jsem heslo</a>
    <a href="registration.php" class="btn btn-light">registrovat se</a>
    <a href="./" class="btn btn-light">zrušit</a>
  </form>

<?php
  //vložíme do stránek patičku
  include __DIR__.'/inc/footer.php';