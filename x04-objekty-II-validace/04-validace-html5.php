<?php
if (!empty($_POST)){
  var_dump($_POST);
  exit();
}
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
  <head>
    <title>Ukázka HTML validace</title>
    <meta charset="UTF-8"/>
    <meta http-equiv=X-UA-Compatible content="IE=edge" />
  </head>
  <body>

  <form method="post" action="04-validace-html5.php">
    <table>
      <tr>
        <td><label for="text1">Text s omezenou délkou 5 znaků, required</label></td>
        <td>
          <input type="text" name="text1" id="text1" maxlength="5" required />
          <!--maxlength omezí délku vstupu - víc tam nepůjde napsat-->
        </td>
      </tr>
      <tr>
        <td><label for="text2">E-mail</label></td>
        <td>
          <input type="email" name="text2" id="text2" />
          <!--kontrola, jestli je daným vstupem e-mail-->
        </td>
      </tr>
      <tr>
        <td><label for="text3">URL</label></td>
        <td>
          <input type="url" name="text3" id="text3" />
          <!--kontrola, jestli je daným vstupem URL adresa -->
        </td>
      </tr>
      <tr>
        <td><label for="text4">Barva</label></td>
        <td>
          <input type="color" name="text4" id="text4" />
        </td>
      </tr>
      <tr>
        <td>
          <label for="regular2">3-6 písmen (kontrola regulárním výrazem)</label>
        </td>
        <td>
          <input type="text" id="regular2" pattern="[a-z]{3,6}" title="3 až 6 písmen..." />
        </td>
      </tr>
      <tr>
        <td>
          <label for="number1">Číslo z daného rozmezí 10-20, krokováno po 2</label>
        </td>
        <td>
          <!--Title se zobrazuje jako nápověda v případě chybné hodnoty-->
          <!--lze využít jen některé atributy kontroly-->
          <input type="number" id="number1" min="10" max="20" step="2" title="Číslo z intervalu 10-20." />
        </td>
      </tr>
      <tr>
        <td><label for="date">Datum</label></td>
        <td>
          <input type="date" name="date" id="date"  />
        </td>
      </tr>
      <tr>
        <td>
          <label for="date1">Datum z daného rozmezí</label>
        </td>
        <td>
          <input type="date" id="date1" min="2013-01-01" max="2014-12-31" title="Datum z let 2013-2014" />
        </td>
      </tr>
      <tr>
        <td>
          <input type="submit" value="odeslat s validací" />
          <input type="submit" value="odeslat bez validace" formnovalidate />
          <!--formnovalidate zajistí, že prohlížeč nebude vyžadovat správné vyplnění formuláře-->
        </td>
      </tr>
    </table>
  </form>


  </body>
</html>