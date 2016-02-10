<?php

  define("VYHLEDAVAC", "http://google.com"); //definice konstanty
  define("ESO", "http://eso.vse.cz", true);  //definice konstanty nerozlišující velikost písmen ve svém názvu

  const X = 10; //definice konstanty dostupná v novějších verzích PHP a v definici tříd
  /* v PHP 5.6+ funguje také:
     const Y = X*2; //definice konstanty výpočtem z jiných konstant
  */

  //testovací výpis
  echo VYHLEDAVAC."\n";
  echo eso."\n";
  echo X."\n";
