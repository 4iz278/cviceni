<?php

namespace App\Library;

/**
 * Trait Singleton
 */
trait Singleton{
  private static array $instances=[];
  protected static self $instance;

  /**
   * Singleton creator
   * @return self
   */
  final public static function getInstance():self {
    $className=get_called_class();
      if (!isset(self::$instances[$className])) {
        self::$instances[$className] = new static();
      }
      return self::$instances[$className];
  }
}