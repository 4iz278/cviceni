<?php

  $file = ''; //TODO doplňte sem název reálného souboru a vyzkoušejte si to v praxi

  #region existence a přístupů

  if (file_exists($file)){
    echo 'Soubor '.$file.' existuje.'."\n";
  }

  if (is_file($file)){
    echo $file.' = soubor'."\n";
  }

  if (is_dir($file)){
    echo $file.' = adresář'."\n";
  }

  if (is_readable($file)){
    echo 'Soubor/adresář '.$file.' je možné číst.'."\n";
  }

  if (is_writable($file)){
    echo 'Do souboru/adresáře '.$file.' je možné zapisovat.'."\n";
  }

  #region existence a přístupů

  #region parametry souborů

  echo "Last access: ".date("d.m.Y H:i:s.",fileatime($file))."\n";   //fileatime() vrací timestamp posledního přístupu k souboru

  echo "Last modified: ".date("d.m.Y H:i:s.",filemtime($file))."\n"; //filemtime() vrací timestamp posledního přístupu k souboru

  echo 'Size: '.filesize($file)."\n"; //filesize() vrací velikost souboru (pozor, PHP tuto hodnotu kešuje, pro obnovení je možné zavolat funkci clearstatcache()

  echo 'Přístupy: '.fileperms($file)."\n";
  echo 'Přístupy v běžnější podobě zápisu: '.substr(sprintf("%o",fileperms("test.txt")),-4);

  #endregion parametry souborů

  #region chmod

  chmod($file, 0600); // Read and write for owner, nothing for everybody else
  chmod($file, 0644); // Read and write for owner, read for everybody else
  chmod($file, 0755); // Everything for owner, read and execute for everybody else
  chmod($file, 0740); // Everything for owner, read for owner's group

  #endregion chmod

  #region vlastník a skupina

  echo fileowner($file); //fileowner() vrací aktuálního vlastníka
  //chown($file, $user); //chown() slouží ke změně vlastníka

  echo filegroup($file); //filegroup() vrací aktuální skupinu
  //chgrp($file, $user); //chown() slouží ke změně skupiny

  #endregion vlastník a skupina
