<?php
  if (!empty($_POST['name'])) {
    //pokud nám uživatel poslal své jméno, tak si ho uložíme do cookie (zatím ho nijak nekontrolujeme)

    //pokud nenastavíme platnost, tak je cookie platná jen pro tuto session (tj. do zavření prohlížeče)
    //setcookie("name", $_POST['name']);

    //pokud platnost zadáme, tak si prohlížeč cookie pamatuje po celou dobu její platnosti (pokud ji tedy uživatel ručně nesmaže)
    //pozor, uživatel může cookie klidně upravovat v rámci vývojářských nástrojů v prohlížeči
    //samotná cookie se posílá do prohlížeče jako HTTP hlavička, tj. musíme ji odeslat před doctypenm
    setcookie("name", $_POST['name'], time()+3600); //teď + 3600 sekund = 1 hodina

    header('Location: index.php');//přesměrujeme uživatele na homepage
  }
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>About me - PHP Shopping App</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
  </head>
  <body>
	
	  <?php include 'navbar.php' ?>
		
	  <h1>About me</h1>

	  <form method="post">
      <!--máme tu jednoduchý "přihlašovací" formulář, ve kterém může uživatel jen zadat své jméno, zatím bez jakékoliv kontroly-->
      <label for="name">My Name</label><br/>
		  <input type="text" name="name" id="name" value="<?php echo htmlspecialchars(@$_COOKIE['name']); ?>" required /><!--do formuláře vypisujeme jméno uložené v cookie (pokud tam je)-->
      <br/><br/>
      <input type="submit" value="Save"> or <a href="./">Cancel</a>
	  </form>

  </body>
</html>
