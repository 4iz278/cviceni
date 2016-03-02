<?php
  require 'header.inc.php';//stejné jako require('header.inc.php');
?>

  <p>Vítejte na ukázkové stránce!</p>

<?php

  @include 'slogan.inc.php';
    //pomocí include načítáme soubory, které když se nepovede načíst, tak se vlastně nic moc nestane
    //TODO: Proč je před "include" zavináč?

  require 'footer.inc.php';
