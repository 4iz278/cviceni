<?php


abstract class BaseModel{
  /** @var PDO */
  protected $pdo;

  /**
   * BaseModel constructor - zajišťuje připojení k DB
   */
  public function __construct(){
    $this->pdo= new PDO(DB_CONNECTION_STRING,DB_USERNAME,DB_PASSWORD);
  }

}