<?php

/** Jednoduchý příklad definice třídy a jejího použití */

/**
 * Class Clovek
 * @property string $jmeno //z hlediska dokumentac je jedno, jestli public proměnné definujete takto, nebo v rámci dokumentace jednotlivých proměnných
 * @property string $prijmeni
 */
class Clovek{
  public $jmeno;
  public $prijmeni;
  /** @var string[] $poznamky  */
  private $poznamky=[]; //private proměnná je přístupná jen v rámci dané třídy (ne v rámci potomků)
  /** @var string $id = '' */
  protected $id = ''; //protected proměnnou nebude možné překrýt v rámci potomka

  /**
   * @param string $jmeno=''
   * @param string $prijmeni=''
   */
  public function __construct($jmeno='', $prijmeni=''){
    $this->jmeno=$jmeno;
    $this->prijmeni=$prijmeni;
    $this->generateId();
  }

  /**
   * Metoda pro vygenerování nového id
   */
  final private function generateId(){ //pokud u definice metody použijeme klíčové slovo final, nebude ji možné překrýt v rámci potomka
    $this->id = uniqid();
  }

  /**
   * Metoda pro výpis daného objektu
   * @return string
   */
  public function __toString(){
    return $this->jmeno.' '.$this->prijmeni;
  }

}

/**
 * Class Student - ukázka rozšiřující třídy
 */
class Student extends Clovek{
  protected $rocnik = 1;

  /**
   * Funkce pro výpis - překrývá
   * @return string
   */
  public function __toString(){
    return parent::__toString().' - rocnik '.$this->rocnik.' (id:'.$this->id.')';
    //pokud chceme pracovat s překrytou metodou, můžeme se k ní dostat pomocí klíčového slova parent
    //přístupné proměnné a metody (public nebo protected) jsou normálně dostupné, i když byly definovány v rodičovské třídě
  }
}



$pepa = new Student('Josef','Novák');
echo $pepa; //při výpisu se použije funkce __toString()


