<?php

  /**
   * Class Osoba - ukázka využití metody toString
   */
  class Osoba{
    public function __construct(
      public string $jmeno,
      public string $prijmeni
    ){}

    public function __toString():string{
      /*
       * Metoda __toString automaticky se používá při přetypování objektu na string (např. při echo, spojení řetězců atp.)
       * Z hlediska praktického použití by měla jen vracet string, nic v ní přímo nevypisujeme
       * Ideálně vracejte jen text, ne HTML kód
       */
      return $this->jmeno.' '.$this->prijmeni;
    }

  }

  $osoba = new autoload\Osoba('David', 'Silvestr');

  echo $osoba;
  var_dump($osoba);

  $celeJmenoOsoby = (string)$osoba;
  echo 'Délka jména: '.mb_strlen($celeJmenoOsoby, 'UTF-8');