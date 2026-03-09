<?php
  namespace MujJmennyProstor;

  /**
   * Class Osoba - ukázková třída podporující serializaci pomocí __serialize a __unserialize
   * @package MujJmennyProstor
   */
  class Osoba{

    public string $jmeno;
    public string $prijmeni;
    private string $heslo;

    /**
     * Funkce definující, jaká data se mají serializovat
     */
    public function __serialize(): array {
      //všechna potřebná data třídy převedeme do pole, které následně převedeme na řetězec
      return [
        'jmeno'=>$this->jmeno,
        'prijmeni'=>$this->prijmeni
      ];
    }

    public function unserialize(array $serialized): void {
      $this->jmeno = $serialized['jmeno'];
      $this->prijmeni = $serialized['prijmeni'];
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