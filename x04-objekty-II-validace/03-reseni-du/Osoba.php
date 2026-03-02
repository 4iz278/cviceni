<?php

namespace Skola;

/**
 * Class Osoba - základní třída představující osobu
 * @package Skola
 * @author Stanislav Vojíř
 */
class Osoba{
  /** @var string $jmeno */
  public $jmeno; /*v PHP 7.4 už je možné definovat datové typy i pro properties, ale to na serveru eso ještě nemáme*/
  /** @var string $prijmeni */
  public $prijmeni;

  /**
   * Osoba constructor.
   * @param string $jmeno = ''
   * @param string $prijmeni = ''
   */
  public function __construct(string $jmeno = '', string $prijmeni = ''){
    $this->jmeno=$jmeno;
    $this->prijmeni=$prijmeni;
  }

}