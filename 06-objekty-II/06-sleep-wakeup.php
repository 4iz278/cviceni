<?php
  /**
   * Class Osoba - ukázková třída implementující rozhraní Serializable
   */
  class Osoba{

    public string $jmeno;
    public string $prijmeni;

    /**
     * Funkce vracející pole se seznamem properties, které chceme serializovat
     */
    public function __sleep(): array {
      //funkce může např. zrušit připojení k DB atp.

      return ['jmeno','prijmeni'];
    }

    /**
     * Funkce pro probuzení objektu - např. obnovení připojení k DB
     * volá se automaticky při unserializaci objektu
     */
    public function __wakeup(): void {
      // zde bychom mohli např. znovu navázat připojení k databázi atp.
    }
  }

  $osoba = new autoload\Osoba();
  $osoba->jmeno='Joanne';
  $osoba->prijmeni='Rowling';

  $serializovanaOsoba = serialize($osoba);
  var_dump($serializovanaOsoba);

  unset($osoba);

  $osoba = unserialize($serializovanaOsoba);
  var_dump($osoba);