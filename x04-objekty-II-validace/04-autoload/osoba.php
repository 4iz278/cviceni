<?php

/**
 * Class Osoba
 */
class Osoba{
  /** @var  string $jmeno */
  public $jmeno;
  /** @var Ukol[] $ukoly */
  public $ukoly = [];

  /**
   * @param $nazevUkolu
   */
  public function pridatUkol($nazevUkolu){
    $this->ukoly[]=new Ukol($nazevUkolu);
  }

}