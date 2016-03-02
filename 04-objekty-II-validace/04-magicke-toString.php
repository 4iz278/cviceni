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
      return $this->jmeno.' '.$this->prijmeni;
    }

  }


  $osoba = new Osoba();
  $osoba->jmeno='David';
  $osoba->prijmeni='Silvestr';

  echo $osoba;