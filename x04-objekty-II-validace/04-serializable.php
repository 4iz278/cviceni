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
      $data=[
        'jmeno'=>$this->jmeno,
        'prijmeni'=>$this->prijmeni
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
      $this->jmeno=$data['jmeno'];
      $this->prijmeni=$data['prijmeni'];
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