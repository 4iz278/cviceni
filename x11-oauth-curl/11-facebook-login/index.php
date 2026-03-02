<?php
  //načteme připojení k databázi a inicializujeme session
  require_once 'inc/user.php';
  //načteme inicializaci knihovny pro Facebook
  require_once 'inc/facebook.php';

  //vložíme do stránek hlavičku
  include __DIR__.'/inc/header.php';

  if (!empty($_SESSION['user_id'])){
    echo '<p>Přihlášený uživatel: <strong>'.htmlspecialchars($_SESSION['user_name']).'</strong></p>';
    echo '<a href="logout.php" class="btn btn-primary">odhlásit se</a>';
  }else{
    echo '<p>Uživatel není přihlášen.</p>';
    echo '<a href="login.php" class="btn btn-primary">přihlásit se</a>';

    #region přihlašování pomocí Facebooku
    //inicializujeme helper pro vytvoření odkazu
    $fbHelper = $fb->getRedirectLoginHelper();

    //nastavení parametrů pro vyžádání oprávnění a odkaz na přesměrování po přihlášení
    $permissions = ['email'];
    $callbackUrl = htmlspecialchars('https://eso.vse.cz/~xname/11-facebook-login/fb-callback.php');
    //TODO nezapomeňte v předchozím řádku upravit adresu ke své vlastní aplikaci

    //necháme helper sestavit adresu pro odeslání požadavku na přihlášení
    $fbLoginUrl = $fbHelper->getLoginUrl($callbackUrl, $permissions);

    //vykreslíme odkaz na přihlášení
    echo ' <a href="'.$fbLoginUrl.'" class="btn btn-primary">přihlásit se pomocí Facebooku</a>';
    #endregion přihlašování pomocí Facebooku
  }

  //vložíme do stránek patičku
  include __DIR__.'/inc/footer.php';