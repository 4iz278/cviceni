<?php
  /**
   * Class Osoba - ukázková třída implementující rozhraní Serializable
   */
  class Osoba{

    public $jmeno;
    public $prijmeni;

    /**
     * Funkce vracející pole se seznamem properties, které chceme serializovat
     * @return array
     */
    public function __sleep(){
      //funkce může např. zrušit připojení k DB atp.

      return ['jmeno','prijmeni'];
    }

    /**
     * Funkce pro probuzení objektu - např. obnovení připojení k DB
     */
    public function __wakeup($serialized){

    }
  }

  $osoba = new Osoba();
  $osoba->jmeno='Joanne';
  $osoba->prijmeni='Rowling';

  $serializovanaOsoba = serialize($osoba);
  var_dump($serializovanaOsoba);

  unset($osoba);

  $osoba = unserialize($serializovanaOsoba);
  var_dump($osoba);