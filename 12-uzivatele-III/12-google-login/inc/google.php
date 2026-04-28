<?php

  use League\OAuth2\Client\Provider\Google;

  $google = new Google([//TODO doplnit vlastní údaje
    'clientId'     => 'YOUR_CLIENT_ID',
    'clientSecret' => 'YOUR_CLIENT_SECRET',
    'redirectUri'  => 'https://eso.vse.cz/~xname/12-google-login/google-callback.php',
  ]);