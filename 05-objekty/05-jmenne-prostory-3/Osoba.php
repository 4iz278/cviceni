<?php

namespace Application\Model;

/**
 * Class Osoba
 * @package Application\Model
 */
class Osoba{
  private string $jmeno='';

  public function __construct(string $jmeno){
    $this->jmeno=$jmeno;
  }

  public function __toString():string{
    return $this->jmeno;
  }

}