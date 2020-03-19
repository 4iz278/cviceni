<?php
  /** @var string[] $chyby - proměnná pro shromažďování chyb */
  $chyby = [];

  if (!empty($_POST)){
    #region kontrola zaslaných dat
    if (empty($_POST['name']) || !strpos(trim($_POST['name']),' ')){
      //kontrolujeme, zda je zadané jméno a zda obsahuje mezeru
      $chyby['name']='Musíte zadat své jméno a příjmení.';
    }

    if (empty($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
      $chyby['email']='Musíte zadat platný e-mail.';
    }

    if (!empty($_POST['phone'])){
      //odstraníme z telefonu nadbytečné znaky
      $_POST['phone']=str_replace([' ','-','/'],['','',''],$_POST['phone']);
      //kontrola regulárním výrazem - chceme jen česká čísla
      if (!preg_match('/^(\+420)?[0-9]{9}$/',$_POST['phone'])){
        $chyby['email']='Musíte zadat platné české telefonní číslo, nebo ponechte toto pole prázdné.';
      }
    }
    #endregion kontrola zaslaných dat
    if (empty($chyby)){
      #region uložení dat
      $data = [
        $_POST['name'],
        $_POST['email'],
        (!empty($_POST['phone'])?$_POST['phone']:'')
      ];

      $file=fopen('data.csv','a');
      fputcsv($file,$data,';');
      fclose($file);
      #endregion uložení dat
      #region přesměrování
      header('Location: formular.php');
      return;
      #endregion přesměrování
    }
  }

?><!DOCTYPE html>
<html lang="cs">
  <head>
    <title></title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">

      <form method="post">
        <div class="form-group">
          <label for="name">Jméno a příjmení:</label>
          <input type="text" name="name" id="name" maxlength="100" class="form-control<?php echo (!empty($chyby['name'])?' is-invalid':''); ?>" value="<?php echo htmlspecialchars(@$_POST['name'])?>" required />
          <?php
            if (!empty($chyby['name'])){
              echo '<div class="invalid-feedback">'.$chyby['name'].'</div>';
            }
          ?>
        </div>
        <div class="form-group">
          <label for="email">Jméno a příjmení:</label>
          <input type="email" name="email" id="email" class="form-control<?php echo (!empty($chyby['email'])?' is-invalid':''); ?>" value="<?php echo htmlspecialchars(@$_POST['email'])?>" required />
          <?php
            if (!empty($chyby['email'])){
              echo '<div class="invalid-feedback">'.$chyby['email'].'</div>';
            }
          ?>
        </div>
        <div class="form-group">
          <label for="phone">Telefon:</label>
          <input type="tel" name="phone" id="phone" class="form-control<?php echo (!empty($chyby['phone'])?' is-invalid':''); ?>" value="<?php echo htmlspecialchars(@$_POST['phone'])?>" />
          <?php
            if (!empty($chyby['phone'])){
              echo '<div class="invalid-feedback">'.$chyby['phone'].'</div>';
            }
          ?>
        </div>
        <button type="submit" class="btn btn-primary">Registrovat se</button>
      </form>

    </div>
  </body>
</html>
