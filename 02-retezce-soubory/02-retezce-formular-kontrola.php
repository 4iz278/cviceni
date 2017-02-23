<?php
  if (!empty($_POST)){
    $chyby='';

    if (strpos(trim(@$_POST['jmeno']),' ')===false){
      $chyby.='<p>Je nutné zadat jméno a příjmení! (min. 2 slova)</p>';
    }
    if (mb_strlen(trim(@$_POST['adresa']),'utf8')<5){
      $chyby.='<p>Je nutné zadat adresu!</p>';
    }

    if (!$chyby){
      echo 'Jméno: '.$_POST['jmeno']."\n";
      echo 'Adresa: '.$_POST['adresa']."\n";
      exit();
    }
  }

?><!DOCTYPE html>
<html>
<head>
  <title>Ukázka HTML formuláře s jednoduchou kontrolou</title>
  <meta charset="UTF-8" />
</head>
<body>

<h1>Ukázka formuláře s jednoduchou kontrolou</h1>
<?php
  if (!empty($chyby)){
    echo '<div style="color: red;">'.$chyby.'</div>';
  }
?>
<form method="post">
  <label for="jmeno" >Jméno a příjmení:</label>
  <input type="text" name="jmeno" id="jmeno" value="<?php echo htmlspecialchars(@$_POST['jmeno']);?>" />
  <br />
  <label for="adresa">Adresa:</label>
  <textarea id="adresa" name="adresa"><?php echo htmlspecialchars_decode(@$_POST['adresa'])?></textarea>
  <br />
  <input type="submit" value="Odeslat..."/>
</form>

</body>
</html>