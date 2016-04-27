<?php

namespace Blog\Model;

use \PDO;

/**
 * Class BaseModel
 * @package Blog\Model
 */
abstract class BaseModel{
  /** @var PDO */
  protected static $pdo;

  /**
   * BaseModel constructor - zajišťuje připojení k DB
   */
  public function __construct(){
    if (!self::$pdo instanceof PDO){
      self::$pdo= new PDO(DB_CONNECTION_STRING,DB_USERNAME,DB_PASSWORD);
    }
  }

}