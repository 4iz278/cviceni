<!DOCTYPE html>
<html lang="cs">
  <head>
    <title><?php echo (!empty($pageTitle)?$pageTitle.' - ':'')?>Nástěnka</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  </head>
  <body>
    <header class="container bg-dark">
      <h1 class="text-white py-4 px-2">Nástěnka</h1>

      <div class="text-right text-white">
      <?php
        if (!empty($_SESSION['user_id'])){
          echo '<strong>'.htmlspecialchars($_SESSION['user_name']).'</strong>';
          echo ' - ';
          echo '<a href="logout.php" class="text-white">odhlásit se</a>';
        }else{
          echo '<a href="login.php" class="text-white">přihlásit se</a>';
        }
      ?>
      </div>
    </header>
    <main class="container pt-2">