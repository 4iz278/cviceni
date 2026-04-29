<?php

  //nejprve si vynutíme, aby byl uživatel přihlášený
  require 'user_required.php';

  //ověříme, jestli je uživatel v roli admin - pokud ne, tak mu zabráníme v přístupu
  if(empty($currentUser) || ($currentUser['role']!='admin')){
    die('Tato stránka je dostupná pouze administrátorům.');
  }