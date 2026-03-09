<?php

namespace MujJmennyProstor;

  /**
   * Class Osoba
   */
class Osoba{
    public string $jmeno;
    /** @var Ukol[] $ukoly */
    public array $ukoly=[];

    public function pridatUkol(string $nazevUkolu):void {
      $this->ukoly[]=new Ukol($nazevUkolu);
    }

  }