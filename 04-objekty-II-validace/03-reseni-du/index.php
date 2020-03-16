<?php

  namespace Skola;

  #region definice autoload funkce (což je jedním z témat dalšího cvičení)
  spl_autoload_register(function($className){
    if (substr($className,0,6)!='Skola\\'){
      //nejde o třídu z našeho namespace
      return false;
    }
    $filename=substr($className,6).'.php';//podle názvu požadované třídy určíme soubor, ve kterém by měla být
    return (@include_once($filename));
  });
  #endregion definice autoload funkce (což je jedním z témat dalšího cvičení)

  try{
    $cviceni = new Cviceni(
      "4iz278",
      new Ucebna('doma :)'),
      new Ucitel("Stanislav", "Vojíř"),
      [
        new Student("Jmeno", "Prijmeni", 'prijm01')
      ]
    );
  }catch (\Exception $e){
    echo 'Chybné zadání seznamu studentů.';
  }

  var_dump($cviceni);