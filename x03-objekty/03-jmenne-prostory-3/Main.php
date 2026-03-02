<?php

namespace Application;

require_once 'Osoba.php';//načteme zdrojové kódy dalších tříd (autoload si vysvětlíme na 4. cvičení)

use Application\Model\Osoba;//importujeme třídu z jiného jmenného prostoru

/**
 * Class Main
 * @package Application
 */
class Main{

  public static function spustit(){
    $osoba = new Osoba('nevim');//třída osoba již byla naimportována, používáme ji bez jmenného prostoru
    echo $osoba;
  }

}


Main::spustit();