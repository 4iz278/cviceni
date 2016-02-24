<?php

  $file = ''; //TODO doplňte sem název reálného souboru a vyzkoušejte si to v praxi

  $filename = basename($file);  //funkce pro zjištění jména souboru
  $path = dirname($file);       //funkce pro zjištění jména adresáře

  #region manipulace se soubory

  copy($file, $file.'2'); //vytvoří kopii souboru

  rename($file.'2', $file.'-prejmenovano'); //přejmenuje soubor; pomocí rename() lze soubor také přesunout
  //pokud chcete přesunout nahraný soubor (odeslaný pomocí formuláře), použijte funkci move_uploaded_file()

  unlink($file);//smaže soubor

  #endregion manipulace se soubory


  #region manipulace s adresáři

  mkdir($path.DIRECTORY_SEPARATOR.'testovaciAdresar');//vytvoření adresáře
  mkdir($path.DIRECTORY_SEPARATOR.'testovaciAdresar2/adresar2', 0777, true);//vytvoření adresáře se zadáním přístupových práv a zapnutou možností rekurzivního vytvoření adr. struktury

  rename($path.DIRECTORY_SEPARATOR.'testovaciAdresar', $path.DIRECTORY_SEPARATOR.'testovaciAdresarX');//přejmenování funguje stejně, jako u souborů

  rmdir($path.DIRECTORY_SEPARATOR.'testovaciAdresarX');//smaže adresář

  #endregion manipulace s adresáři