<?php
  session_start();  //spustíme práci se session
  session_destroy();//zrušíme aktuální session

  // alternativně bychom mohli jen smazat info o uživateli, zbytek info v session by zůstal zachovaný
  // unset($_SESSION['user']);

  header('Location: index.php');//přesměrování na homepage
