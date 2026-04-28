<?php
  use League\OAuth2\Client\Provider\Google;

  /** @var \PDO $db */
  require_once __DIR__.'/inc/user.php';

  //knihovna pro Google API
  /** @var Google $google */
  require_once __DIR__.'/inc/google.php';

  // vygenerujeme URL pro přihlášení
  $authUrl = $google->getAuthorizationUrl([
    'scope' => ['openid', 'email', 'profile']
  ]);

  // uložíme state (ochrana proti CSRF); do budoucna bychom mohli do state ukládat i informace pro zpětné přihlášení při fly-loginu atp.
  $_SESSION['oauth2state'] = $google->getState();

  // přesměrování na Google
  header('Location: ' . $authUrl);