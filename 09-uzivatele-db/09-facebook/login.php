<?php
session_start();
	
require_once __DIR__ . '/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '{app-id}', // TODO Replace {app-id} with your app-id
  'app_secret' => '{app-secret}', // TODO Replace {app-secret} with your app-secret
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://eso.vse.cz/~xhraj18/09-facebook/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';

?>