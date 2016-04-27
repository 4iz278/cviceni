<?php
  namespace Blog\Library;

  /*autoloader*/
  class Autoloader{
    const BASE_PATH='./application/';
    
    public static function controllerExists($class){
      return file_exists(self::BASE_PATH.'controllers/'.$class.'.php');
    }
    
    public static function autoloadWithNamespaces($class){
      if (substr($class,0,5)!='Blog\\'){return false;}
      if (substr($class,0,13)=='Blog\\Library\\'){
        $file='library/'.substr($class,13).'.php';
      }elseif (substr($class,0,17)=='Blog\\Controllers\\'){
        $file='controllers/'.substr($class,17).'.php';
      }elseif (substr($class,0,13)=='Blog\\Layouts\\'){
        $file='layouts/'.substr($class,13).'.php';
      }elseif(substr($class,0,11)=='Blog\\Views\\'){
        $file='views/'.str_replace('_','/',substr($class,11)).'.php';
      }elseif(substr($class,0,11)=='Blog\\Model\\'){
        $file=substr($class,11);
        if (substr($file,0,9)=='Entities\\'){
          $file='entities/'.substr($file,9);
        }
        $file='model/'.$file.'.php';
      }
      if (empty($file)){return false;}
      return self::_autoload($file);
    }

    public static function autoloadLibrary($class){
      $file = 'library/'.str_replace('_', '/', $class). '.php';
      return self::_autoload($file);
    }
   
    private static function _autoload($file){
      if (file_exists(self::BASE_PATH.$file)) {
          @include_once self::BASE_PATH.$file;
          return true;
      }
      return false;
    }

    public static function registerSplAutoload(){
      spl_autoload_register(array('Blog\Library\Autoloader','autoloadWithNamespaces'));
      spl_autoload_register(array('Blog\Library\Autoloader','autoloadLibrary'));
    }
  }

  
