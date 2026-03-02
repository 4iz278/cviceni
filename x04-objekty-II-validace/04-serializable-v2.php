<?php
  namespace MujJmennyProstor;

  /**
   * Class Osoba - ukázková třída implementující rozhraní Serializable
   * @package MujJmennyProstor
   */
  class Osoba implements \Serializable{ //TODO: proč je před názvem rozhraní Serializable zpětné lomítko?

    public $jmeno;
    public $prijmeni;

    /**
     * String representation of object
     * @return string
     */
    public function serialize(){
      //všechna potřebná data třídy převedeme do pole, které následně převedeme na řetězec
      //serializace do indexovaného pole je oproti asociačnímu poli datově úspornější
      $data=[
        $this->jmeno,
        $this->prijmeni
      ];
      return serialize($data);
    }

    /**
     * Constructs the object
     * @param string $serialized
     * @return void
     */
    public function unserialize($serialized){
      $data = unserialize($serialized);
      list($this->jmeno, $this->prijmeni) = $data;
      /*konstrukce list() umožňuje postupně naplnit proměnné z indexovaného pole

        $this->jmeno=$data[0];
        $this->jmeno=$data[1];
      */

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