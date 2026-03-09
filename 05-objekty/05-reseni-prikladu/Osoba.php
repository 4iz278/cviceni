<?php

namespace Skola;

/**
 * Class Osoba - základní třída představující osobu
 * @package Skola
 * @author Stanislav Vojíř
 */
class Osoba{

  public function __construct(
    public string $jmeno = '',
    public string $prijmeni = ''){
  }

}