<?php
  session_start();  //spustíme práci se session
  session_destroy();//zrušíme aktuální session

  header('Location: ./');//přesměrování na homepage
