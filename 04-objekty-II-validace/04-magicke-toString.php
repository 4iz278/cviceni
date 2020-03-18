<?php

  /**
   * Class Osoba - ukázka využití metody toString
   */
  class Osoba{
    public $jmeno, $prijmeni;

    /**
     * @return string
     */
    public function __toString(){
      /*
       * Metoda __toString automaticky se používá při přetypování objektu na string.
       * Z hlediska praktického použití by měla jen vracet string, nic v ní přímo nevypisujeme! Zároveň z ní nevracejte HTML kód.
       */
      return $this->jmeno.' '.$this->prijmeni;
    }

  }


  $osoba = new Osoba();
  $osoba->jmeno='David';
  $osoba->prijmeni='Silvestr';

  echo $osoba;