<!DOCTYPE html>
<html>
  <head>
    <title>Formulář s GET</title>
    <meta charset="UTF-8"/>
  </head>
  <body>
    <h1>Ukázka získání hodnoty z $_GET</h1>
    <?php
      if (!empty($_GET['text'])){//Co by tak mohla dělat funkce empty?
        echo '<h2>Získaná data</h2>';
        echo '<p>'.htmlspecialchars($_GET['text']).'</p>';
      }
    ?>
    <h2>Data k odeslání</h2>
    <form><!--výchozí metodou formuláře je GET, výchozí akcí je aktuální stránka-->
      <label for="text">Data:</label><br />
      <textarea name="text" id="text"></textarea><br />
      <input type="submit" value="odeslat..." />
    </form>
  </body>
</html>