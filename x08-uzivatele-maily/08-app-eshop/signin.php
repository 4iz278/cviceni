<?php
  //spustíme session
  session_start();

  //připojení k databázi
  require 'db.php';
	
  if (!empty($_POST)){
      $email = @$_POST['email'];
      $password = @$_POST['password'];

      # zajimavost: mysql porovnani retezcu je case insensitive, pokud dame select na NECO@DOMENA.COM, najde to i zaznam neco@domena.com
      # viz http://dev.mysql.com/doc/refman/5.0/en/case-sensitivity.html

      $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1"); //limit 1 je tu jen jako vykonnostní optimalizace, 2 stejné maily v DB nebudou
      $stmt->execute([$email]);

      if (($existingUser=$stmt->fetch(PDO::FETCH_ASSOC)) && password_verify($password, @$existingUser['password'])){
        //povedlo se nám najít daného uživatele v DB a zároveň bylo zadáno platné heslo => uložíme si ID uživatele do SESSION a přesměrujeme ho na homepage
        $_SESSION['user_id'] = $existingUser['id'];
        header('Location: index.php');
      }else{
        //u přihlášení uživatele nezobrazujeme konkrétní chybu (je to jediná výjimka, kdy není vhodné mít u formuláře úplně konkrétní chybu)
        $formError="Invalid user or password!";
      }
  }?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>PHP Shopping App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>
	
    <h1>PHP Shopping App</h1>

    <h2>Sign in</h2>

    <?php
      if (!empty($formError)){
        echo '<p style="color:red;">'.$formError.'</p>';
      }
    ?>

    <form method="post">
      <label for="email">Your Email</label><br/>
      <input type="text" name="email" id="email" value="<?php echo htmlspecialchars(@$_POST['email'])?>"><br/><br/>

      <label for="password">Password</label><br/><!--POZOR: heslo nikdy nepředvyplňujeme! -->
      <input type="password" name="password" id="password" value=""><br/><br/>

      <input type="submit" value="Sign in">
    </form>

    <br/>

    <a href="signup.php">Don't have an account yet? Sign up!</a>

  </body>
</html>
