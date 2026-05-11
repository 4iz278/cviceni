<?php

namespace Blog\Model;

use \PDO;

/**
 * Class BaseModel
 * @package Blog\Model
 */
abstract class BaseModel{
  protected static ?PDO $pdo = null;

  /**
   * BaseModel constructor - zajišťuje připojení k DB
   */
  public function __construct(){
    if (!self::$pdo){
      self::$pdo= new PDO(DB_CONNECTION_STRING,DB_USERNAME,DB_PASSWORD);
    }
  }

}