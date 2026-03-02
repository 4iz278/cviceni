<?php

/** Jednoduchá ukázka kódu s autoloadem */
spl_autoload_register(function($className){//definujeme (anonymní) funkci, která se postará o načítání potřebných kódů tříd, rozhraní a traitů

  $filename=strtolower($className).'.php';//podle názvu požadované třídy určíme soubor, ve kterém by měla být

  if (file_exists($filename)){//pokud soubor existuje, tak ho načteme
    require_once $filename;
    return true;
  }else{
    return false;
  }

});


$osoba = new Osoba();
$osoba->jmeno = 'nikdo :)';
$osoba->pridatUkol('uklidit...');

var_dump($osoba);
