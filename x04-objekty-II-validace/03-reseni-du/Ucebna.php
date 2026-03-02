<?php

  namespace Skola;
  /**
   * Class Ucebna
   * @package Skola
   * @author Stanislav Vojíř
   */
  class Ucebna{
    /** @var string $id */
    public $id;

    /**
     * Ucebna constructor.
     * @param string $id
     */
    public function __construct(string $id){
      $this->id=$id;
    }
  }