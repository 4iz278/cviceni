<?php

namespace Blog\Library;

/**
 * Trait Singleton
 * @package Blog\Library
 */
trait Singleton{
  private static $instances=[];
  protected static $instance;

  /**
   * Singleton creator
   * @return static
   */
  final public static function getInstance(){
    $className=get_called_class();
    if(!isset(self::$instances[$className])){
      self::$instances[$className]=new static();
    }
    return self::$instances[$className];
  }

  private function __clone(){
    //touto metodou zakazujeme klonování daného objektu
  }
}