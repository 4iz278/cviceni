<?php
  /**
   * PHP HTTP autentizace typu Basic
   * http://php.net/manual/en/features.http-auth.php
   */

  $validUsers = [
    //pro zjednodušení testování tu máme hesla nešifrovaně, ale to fakt NENÍ BEZPEČNÉ!
    //TODO zvládli byste upravit tento soubor tak, aby tu místo hesel byl uložen jejich hash?
    //TODO zvládli byste zařídit také to, aby aplikace ignorovala velikost písmen v uživatelském jméně?
    "admin" => "shelby",
    "jirka"=>"gt"
  ];

  $user = @$_SERVER['PHP_AUTH_USER']; //pokud je uživatel přihlášený HTTP autentizací, najdeme jeho jméno i heslo v $_SERVER
  $password = @$_SERVER['PHP_AUTH_PW'];

  $validated = (isset($validUsers[$user])) && ($password == $validUsers[$user]);

  if (!$validated) {
    //uživatel není přihlášený => odešleme HTTP hlavičky pro výzvu k přihlášení
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    die ("Unauthorized");
  }