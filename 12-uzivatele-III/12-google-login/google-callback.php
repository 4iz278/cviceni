<?php
  use League\OAuth2\Client\Provider\Google;

  /** @var \PDO $db */
  require_once __DIR__.'/inc/user.php';

  //knihovna pro Google API
  /** @var Google $google */
  require_once __DIR__.'/inc/google.php';

  // kontrola state (CSRF ochrana)
  if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
  }

  // máme autorizační kód?
  if (!isset($_GET['code'])) {
    exit('No code received');
  }

  try {
    // výměna kódu za token
    $token = $google->getAccessToken('authorization_code', [
      'code' => $_GET['code']
    ]);

    // získání údajů o uživateli
    $user = $google->getResourceOwner($token);

    $googleId = $user->getId();
    $email    = $user->getEmail();
    $name     = $user->getName();

    #region přihlášení uživatele
    //nejprve se pokusíme daného uživatele načíst podle google_id
    $query=$db->prepare('SELECT * FROM users WHERE google_id=:googleId LIMIT 1;');
    $query->execute([
      ':googleId'=>$googleId
    ]);

    if ($user = $query->fetch(PDO::FETCH_ASSOC)){
      //uživatele jsme našli v DB podle jeho google_id (v budoucnu můžeme tuto větev odstranit, tady už nic řešit nebudeme)
    }else{
      //uživatel nebyl nalezen v DB
      $query = $db->prepare('SELECT * FROM users WHERE email=:email LIMIT 1;');
      $query->execute([
        ':email'=>$email
      ]);

      if ($user = $query->fetch(PDO::FETCH_ASSOC)){
        //uživatele jsme našli podle e-mailu, připíšeme k němu do DB jeho google_id
        $updateQuery = $db->prepare('UPDATE users SET google_id=:googleId WHERE user_id=:id LIMTI 1;');
        $updateQuery->execute([
          ':googleId'=>$googleId,
          ':id'=>$user['user_id']
        ]);

      }else{
        //uživatele jsme vůbec nenašli, zapíšeme ho do DB jako nového
        $insertQuery = $db->prepare('INSERT INTO users (name, email, google_id) VALUES (:name, :email, :googleId);');
        $insertQuery->execute([
                                ':name'=>$name,
                                ':email'=>$email,
                                ':googleId'=>$googleId
                              ]);

        //uživatele následně zpětně načteme z DB pro získání jeho user_id
        $query=$db->prepare('SELECT * FROM users WHERE google_id=:googleId LIMIT 1;');
        $query->execute([
                          ':googleId'=>$googleId
                        ]);
        $user=$query->fetch(PDO::FETCH_ASSOC);
      }
    }

    if (!empty($user)){
      //přihlásíme uživatele (uložíme si jeho údaje do session)
      session_regenerate_id();
      $_SESSION['user_id']=$user['user_id'];
      $_SESSION['user_name']=$user['name'];
    }

    //přesměrujeme uživatele na homepage
    header('Location: ./');

    #endregion přihlášení uživatele

  } catch (Exception $e) {
    exit('Chyba: ' . $e->getMessage());
  }