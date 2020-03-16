<?php


  namespace Skola;

  /**
   * Class Cviceni
   * @package Skola
   * @author Stanislav Vojíř
   */
  class Cviceni{
    /** @var string $predmet */
    public $predmet;
    /** @var Ucebna $ucebna */
    public $ucebna;
    /** @var Ucitel $ucitel */
    public $ucitel;
    /** @var Student[] $studenti */
    private $studenti = [];

    /**
     * Cviceni constructor.
     * @param string $predmet
     * @param Ucebna|null $ucebna = null
     * @param Ucitel|null $ucitel
     * @param Student[] $studenti
     * @throws \Exception
     */
    public function __construct(string $predmet, Ucebna $ucebna=null, Ucitel $ucitel=null,array $studenti = []){
      $this->predmet=$predmet;
      $this->ucebna=$ucebna;
      $this->ucitel=$ucitel;
      if (!empty($studenti)){
        foreach ($studenti as $student){
          //studenty přidáváme postupně, protože kontrolujeme unikátnost jejich xname
          $this->zapsatStudenta($student);
        }
      }

    }

    //následují ukázky nějakých pracovních metod

    /**
     * Metoda pro zapsání studenta na cvičení
     * @param Student $student
     * @throws \Exception
     */
    public function zapsatStudenta(Student $student){
      if (!empty($this->studenti) && isset($this->studenti[$student->xname])){
        throw new \Exception('Student '.$student->xname.' již je v daném cvičení zapsaný!');
      }
      $this->studenti[]=$student;
    }

    /**
     * Metoda pro odebrání studenta se zadaným xname
     * @param string $xname
     */
    public function odebratStudentaPodleXname(string $xname){
      if (isset($this->studenti[$xname])){
        unset($this->studenti[$xname]);
      }
    }

    /**
     * Metoda vracející pole se zapsanými studenty
     * @return Student[]
     */
    public function getStudenti():array {
      return $this->studenti;
    }

  }