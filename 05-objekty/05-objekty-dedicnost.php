<?php

/** Jednoduchý příklad definice třídy a jejího použití */

/**
 * Class Clovek
 * @property string $jmeno //z hlediska dokumentac je jedno, jestli public proměnné definujete takto, nebo v rámci dokumentace jednotlivých proměnných
 * @property string $prijmeni
 */
class Clovek{
  /** @var string[] $poznamky  */
  private array $poznamky=[]; //private proměnná je přístupná jen v rámci dané třídy (ne v rámci potomků)
  /** @var string $id = '' */
  protected string $id = ''; //protected proměnnou nebude možné překrýt v rámci potomka

  /**
   * @param string $jmeno=''
   * @param string $prijmeni=''
   */
  public function __construct(public string $jmeno='', public string $prijmeni=''){
    $this->generateId();
  }

  /**
   * Metoda pro vygenerování nového id
   */
  final private function generateId():void{ //pokud u definice metody použijeme klíčové slovo final, nebude ji možné překrýt v rámci potomka
    $this->id = uniqid();
  }

  /**
   * Metoda pro výpis daného objektu
   * @return string
   */
  public function __toString():string{
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


