<?php

spl_autoload_register(function ($className){
  //$className obsahuje název dané třídy včetně jmenného prostoru
  //např. App\Data\Test → App/Data/Test.php

  if (str_starts_with($className, 'App\\')){
    $className=substr($className,4);
    $className=str_replace('\\',DIRECTORY_SEPARATOR,$className);
    $path=__DIR__.DIRECTORY_SEPARATOR.$className.'.php';

    // načtení souboru s třídou
    if (file_exists($path)){
      require $path;
    }
  }
});


$objekt = new \App\Data\Test();