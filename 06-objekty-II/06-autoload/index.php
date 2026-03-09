<?php

/**
 * Jednoduchá ukázka kódu s autoloadem
 * Autoload se zavolá automaticky ve chvíli, kdy PHP narazí na třídu, která ještě není načtena.
 */
spl_autoload_register(function(string $className):void{//definujeme (anonymní) funkci, která se postará o načítání potřebných kódů tříd, rozhraní, traitů a enumů

  $filename=$className.'.php';//podle názvu požadované třídy určíme soubor, ve kterém by měla být

  if (file_exists($filename)){//pokud soubor existuje, tak ho načteme
    require $filename;
  }
});


$osoba = new Osoba();
$osoba->jmeno = 'nikdo :)';
$osoba->pridatUkol('uklidit...');

var_dump($osoba);
