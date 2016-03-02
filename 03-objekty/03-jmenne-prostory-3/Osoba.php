<?php

namespace Application\Model;

/**
 * Class Osoba
 * @package Application\Model
 */
class Osoba{
  /** @var string $jmeno = '' */
  private $jmeno='';

  /**
   * @param string $jmeno
   */
  public function __construct($jmeno){
    $this->jmeno=$jmeno;
  }

  /**
   * @return string
   */
  public function __toString(){
    return $this->jmeno;
  }

}