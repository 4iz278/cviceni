<?php
$chyby=[];//pracovní proměnná, do které budeme shromažďovat info o chybách

if (!empty($_POST) && (@$_POST['akce']=='odeslano')){
  //byl odeslán formulář, provedeme jeho kontrolu
  $_POST['jmeno']=trim(@$_POST['jmeno']);
  if (!preg_match("/^[a-zA-Z -.]{2,}$/",$_POST['jmeno'])){//preg_match kontroluje pomocí regulárního výrazu
    $chyby['jmeno']='Je nutné zadat jméno! Jméno může obsahovat jen písmena, mezeru a pomlčku a mít délku min. 2 znaky.';
  }

  $_POST['prijmeni']=trim(@$_POST['prijmeni']);
  if (!preg_match("/^[a-zA-Z -.]{2,}$/",$_POST['prijmeni'])){
    $chyby['prijmeni']='Je nutné zadat příjmení! Jméno může obsahovat jen písmena, mezeru a pomlčku a mít délku min. 2 znaky.';
  }

  $_POST['email']=trim(@$_POST['email']);
  $_POST['phone']=str_replace([' ','-','/'],'',trim($_POST['phone']));

  if ($_POST['email']!='' && !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){//filter_var umožňuje jednoduchou kontrolu základních typů dat (čísla, mail, url atp.)
    $chyby['email']='Zadaný e-mail není platný!';
  }elseif ($_POST['phone']!='' && !preg_match("/^\+420[0-9]{9}$/",$_POST['phone'])){
    $chyby['phone']='Zadaný telefon není platný!';
  }elseif($_POST['email']=='' && $_POST['phone']==''){
    $chyby['email']='Je nutné zadat telefon či e-mail!';
  }

  if (!in_array($_POST['phone-os'],['android','ios','windows'])){
    //u výběrů je vhodné kontrolovat nejen prázdnost, ale to, zda je hodnota opravdu z cílové množiny
    $chyby['phone-os']='Je nutné vybrat operační systém telefonu!';
  }

  if (empty($chyby)){
    //pokud nebyly nalezeny chyby, tak uložíme získaná data a provedeme redirect
    file_put_contents('data.txt', $_POST['jmeno'].';'.$_POST['prijmeni'].';'.$_POST['email'].';'.$_POST['email'].';'.$_POST['phone-os']."\n",FILE_APPEND);
    header('Location: 04-validace-souhrnna.php?saved=ok');
    exit();
  }

}

/**
 * Funkce pro jednoduché vypsání chyby
 * @param string $id
 */
function vypisChyby($id){
  if (!empty($chyby[$id])){
    echo '<div style="color:red;">'.$chyby[$id].'</div>';
  }
}

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
  <title>Ukázka HTML validace</title>
  <meta charset="UTF-8"/>
  <meta http-equiv=X-UA-Compatible content="IE=edge" />
</head>
<body>

<h1>Ukázka formuláře s validací 2</h1>

<form method="post" action="04-validace-souhrnna.php">
  <input type="hidden" name="akce" value="odeslano"/>
  <table>
    <tr>
      <td><label for="jmeno">Jméno</label></td>
      <td>
        <input type="text" name="jmeno" id="jmeno" value="<?php echo htmlspecialchars(@$_POST['prijmeni']);?>" required />
        <?php vypisChyby('jmeno');?>
      </td>
    </tr>
    <tr>
      <td><label for="prijmeni">Příjmení</label></td>
      <td>
        <input type="text" name="prijmeni" id="prijmeni" value="<?php echo htmlspecialchars(@$_POST['prijmeni']);?>" required />
        <?php vypisChyby('prijmeni');?>
      </td>
    </tr>
    <tr>
      <td><label for="email">E-mail</label></td>
      <td>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars(@$_POST['email']);?>" />
        <?php vypisChyby('email');?>
      </td>
    </tr>
    <tr>
      <td><label for="phone">Telefon</label></td>
      <td>
        <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars(@$_POST['phone']);?>" />
        <?php vypisChyby('phone');?>
      </td>
    </tr>
    <tr>
      <td><label for="phone-os">Telefon - OS</label></td>
      <td>
        <select name="phone-os" id="phone-os">
          <option value="">--vyberte</option>
          <option value="android" <?php echo(@$_POST['phone-os']=='android'?'selected="selected"':'');?>>android</option>
          <option value="ios" <?php echo(@$_POST['phone-os']=='ios'?'selected="selected"':'');?>>ios</option>
          <option value="windows" <?php echo(@$_POST['phone-os']=='windows'?'selected="selected"':'');?>>windows</option>
        </select>
        <?php vypisChyby('phone-os');?>
      </td>
    </tr>
    <tr>
      <td>
        <input type="submit" value="odeslat..." />
      </td>
    </tr>
  </table>
</form>


</body>
</html>