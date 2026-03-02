<?php

  namespace Skola;

  /**
   * Class Student
   * @package Skola
   * @author Stanislav Vojíř
   */
  class Student extends Osoba{
    /** @var string $xname */
    public $xname;

    /**
     * Student constructor.
     * @param string $jmeno = ''
     * @param string $prijmeni = ''
     * @param string $xname = ''
     */
    public function __construct(string $jmeno = '', string $prijmeni = '', string $xname=''){
      parent::__construct($jmeno, $prijmeni);
      $this->xname=$xname;
    }
  }