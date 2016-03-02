<?php

spl_autoload_register(function ($className){
  //$className obsahuje název dané třídy včetně jmenného prostoru

  if (substr($className,0,4)=='App\\'){
    $className=substr($className,4);
    $className=str_replace('\\',DIRECTORY_SEPARATOR,$className);
    $className=__DIR__.DIRECTORY_SEPARATOR.strtolower($className).'.php';

    include_once $className;
    return true;
  }else{
    return false;
  }
});


$objekt = new \App\Data\Test();