<?php
  //načteme připojení k databázi a inicializujeme session
  require_once 'inc/user.php';

  use PHPMailer\PHPMailer\PHPMailer;

  if (!empty($_SESSION['user_id'])){
    //uživatel už je přihlášený, nemá smysl, aby se přihlašoval znovu
    header('Location: index.php');
    exit();
  }

  $errors=false;
  if (!empty($_POST) && !empty($_POST['email'])){
    #region zpracování formuláře
    $userQuery=$db->prepare('SELECT * FROM users WHERE email=:email LIMIT 1;');
    $userQuery->execute([
      ':email'=>trim($_POST['email'])
    ]);
    if ($user=$userQuery->fetch(PDO::FETCH_ASSOC)){
      //zadaný e-mail byl nalezen

      #region vygenerování kódu pro obnovu hesla
      $code='xx'.rand(100000,993952); //rozhodně by tu mohlo být i kreativnější generování náhodného kódu :)

      //uložíme kód do databáze
      $saveQuery=$db->prepare('INSERT INTO forgotten_passwords (user_id, code) VALUES (:user, :code)');
      $saveQuery->execute([
        ':user'=>$user['user_id'],
        ':code'=>$code
      ]);

      //načteme uložený záznam z databáze
      $requestQuery=$db->prepare('SELECT * FROM forgotten_passwords WHERE user_id=:user AND code=:code ORDER BY forgotten_password_id DESC LIMIT 1;');
      $requestQuery->execute([
        ':user'=>$user['user_id'],
        ':code'=>$code
      ]);
      $request=$requestQuery->fetch(PDO::FETCH_ASSOC);

      //sestavíme odkaz pro mail
      $link='https://eso.vse.cz/~xname/11-local-login/renew-password.php';//TODO tady bude potřeba aktualizovat absolutní URL adresu
      $link.='?user='.$request['user_id'].'&code='.$request['code'].'&request='.$request['forgotten_password_id'];
      #endregion vygenerování kódu pro obnovu hesla

      #region poslání mailu pro obnovu hesla
      //inicializujeme PHPMailer pro poslání mailu přes sendmail
      $mailer=new PHPMailer(false);
      $mailer->isSendmail();

      //nastavení adresy příjemce a odesílatele
      $mailer->addAddress($user['email'],$user['name']);//příjemce mailu; POZOR: server eso.vse.cz umí posílat maily jen na školní e-maily!
      //$mailer->setFrom('xname@vse.cz'); //TODO na tomhle řádku by mělo být nastavení reálné adresy odesílatele

      //nastavíme kódování a předmět e-mailu
      $mailer->CharSet='utf-8';
      $mailer->Subject='Obnova zapomenutého hesla';

      $mailer->isHTML(true);
      $mailer->Body ='<html>
                        <head><meta charset="utf-8" /></head>
                        <body>Pro obnovu hesla do Ukázkové aplikace klikněte na následující odkaz: <a href="'.htmlspecialchars($link).'">'.htmlspecialchars($link).'</a></body>
                      </html>';
      $mailer->AltBody='Pro obnovu hesla do Ukázkové aplikace klikněte na následující odkaz: '.$link;

      $mailer->send();
      #endregion poslání mailu pro obnovu hesla

      //přesměrování pro potvrzení
      header('Location: forgotten-password.php?mailed=ok');
    }else{
      //zadaný e-mail nebyl nalezen
      $errors=true;
    }
    #endregion zpracování formuláře
  }

  //vložíme do stránek hlavičku
  include __DIR__.'/inc/header.php';
?>

  <h2>Obnova zapomenutého hesla</h2>
  <?php
    if (@$_GET['mailed']=='ok'){

      echo '<p>Zkontrolujte svoji e-mailovou schránku a klikněte na odkaz, který vám byl zaslán mailem.</p>';
      echo '<a href="index.php" class="btn btn-light">zpět na homepage</a>';

    }else{
  ?>
      <form method="post">
        <div class="form-group">
          <label for="email">E-mail:</label>
          <input type="email" name="email" id="email" required class="form-control <?php echo ($errors?'is-invalid':''); ?>"
                 value="<?php echo htmlspecialchars(@$_POST['email'])?>"/>
          <?php
            echo ($errors?'<div class="invalid-feedback">Neplatný e-mail.</div>':'');
          ?>
        </div>
        <button type="submit" class="btn btn-primary">zaslat e-mail k obnově hesla</button>
        <a href="login.php" class="btn btn-light">přihlásit se</a>
        <a href="index.php" class="btn btn-light">zrušit</a>
      </form>
  <?php
    }
  ?>

<?php
  //vložíme do stránek patičku
  include __DIR__.'/inc/footer.php';