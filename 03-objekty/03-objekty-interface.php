<?php

  /**
   * Interface Vypisovatelne - ukázka definice vlastního rozhraní
   * @author Stanislav Vojíř
   */
  interface Vypisovatelne{ //v rámci definice rozhraní definujeme potřebné metody (optimálně i s popisnými komentáři)
    /**
     *  Funkce zajišťující výpis na výstup
     *  @param string $type
     */
    public function vypis($type);

    /**
     * Funkce vracející jméno
     * @return string
     */
    public static function getName();

  }


  /**
   * Class UkazkovaTrida - ukázková třída implementující 2 rozhraní
   * @author Stanislav Vojíř
   */
  class UkazkovaTrida implements Vypisovatelne, JsonSerializable{ //rozumné IDE vám zvládne doplnit do třídy všechny potřebné metody, do kterých je potřeba doplnit obsah

    /**
     *  Funkce zajišťující výpis na výstup
     * @param string $type
     */
    public function vypis($type){
      // TODO: Implement vypis() method.
    }

    /**
     * Funkce vracející jméno
     * @return string
     */
    public static function getName(){
      // TODO: Implement getName() method.
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize(){
      // TODO: Implement jsonSerialize() method.
    }
  }