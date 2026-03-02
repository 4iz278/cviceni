<?php

  $directoryPath = __DIR__;//konstanta __DIR__ představuje aktuální adresář

  #region scandir

  $content = scandir($directoryPath, SCANDIR_SORT_ASCENDING);//načtení obsahu adresáře do pole, 2. parametr umožňuje určit řazení
  var_dump($content);

  #endregion scandir


  #region opendir

  if (is_dir($directoryPath)) {//kontrola, jestli je zadaný soubor adresářem
    //funkce opendir, readdir a closedir umožňují postupně procházet obsah adresářů obdobně, jako lze postupně číst soubory
    if ($directory = opendir($directoryPath)) {
      while (($file = readdir($directory)) !== false) {
        echo "filename: $file : filetype: " . filetype($directoryPath . $file) . "\n";
      }
      closedir($directory);
    }
  }

  #endregion opendir

  #region dir

  /** @var Directory $d */
  $d = dir($directoryPath); //funkce dir vytvoří instanci objektu Directory pro objektový přístup k adresáři
  while (false !== ($entry = $d->read())) {
    echo $entry."\n";
  }
  $d->close();

  #endregion dir