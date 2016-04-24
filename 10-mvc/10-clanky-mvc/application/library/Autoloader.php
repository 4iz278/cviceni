<?php
  /*autoloader*/
  class Autoloader{
    const BASE_PATH='./application/';
    
    public static function controllerExists($class){
      return file_exists(self::BASE_PATH.'controllers/'.$class.'.php');
    }
    
    public static function autoload($class){
      if (strpos($class,'Controller')){
        $file='controllers/'.$class.'.php';
      }elseif (strpos($class,'Model')){
        $file='model/'.$class.'.php';
      }elseif (strpos($class,'Layout')){
        $file='layouts/'.$class.'.php';
      }else{
        $file='library/'.$class.'.php';
      }
      
      return self::_autoload($file);
    }
   
    public static function autoloadWithSeparator($class){
      if (strpos($class,'View')){   
        $file='views/'.str_replace('_', '/', $class).'.php';
      }else{
        $file = 'library/'.str_replace('_', '/', $class). '.php';
      }
      return self::_autoload($file);
    }
   
    private static function _autoload($file){
      if (file_exists(self::BASE_PATH.$file)) {
          require_once self::BASE_PATH.$file;
          return true;
      }
      return false;
    }

    public static function registerSplAutoload(){
      spl_autoload_register(array('Autoloader','autoload'));
      spl_autoload_register(array('Autoloader','autoloadWithSeparator'));
    }
  }

  
