<!DOCTYPE html>
<html>
<head>
  <title>Ukázka HTML formuláře</title>
  <meta charset="UTF-8"/>
  <style type="text/css">

  </style>
</head>
<body>

<h1>Ukázka jednoduchého formuláře posílaného metodou POST</h1>
<form method="post">
  <label for="jmeno" >Jméno</label>
  <input type="text" name="jmeno" id="jmeno" value="<?php echo htmlspecialchars(@$_POST['jmeno']);?>" />
  <label for="prijmeni" >Příjmení</label>
  <input type="text" name="prijmeni" id="prijmeni" value="<?php echo htmlspecialchars(@$_POST['prijmeni']);?>" />
  <label for="vek" >Věk</label>
  <input type="number" name="vek" id="vek" value="<?php echo htmlspecialchars(@$_POST['vek']);?>" min="0" max="150" step="1" />
  <label for="mail">E-mail</label>
  <input type="email" name="mail" id="mail" value="<?php echo htmlspecialchars(@$_POST['mail'])?>"/>
  <input type="submit" value="Odeslat..."/>
</form>

<?php

//TODO

?>


</body>
</html>