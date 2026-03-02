<?php
date_default_timezone_set("Europe/Prague"); 
session_start();

require_once './application/config.php';
require_once './application/library/Autoloader.php';

Autoloader::registerSplAutoload();

if (@$_REQUEST['controller']!=''){
  $controllerName=ucfirst(trim($_REQUEST['controller'])).'Controller';
}else{
  $controllerName='HomepageController';
  $_REQUEST['controller']='default';
}
if (isset($_REQUEST['action'])){
  $action=trim($_REQUEST['action']).'Action';
}else{
  $action='defaultAction';
}

//overeni existence controlleru a jeho spusteni
//vytvoření controlleru a kontrola, jestli existuje požadovaná metoda
if(Autoloader::controllerExists($controllerName)){
  /** @var $controller controller */
  $controller=new $controllerName();
  if (method_exists($controller,$action)){
      $controller->$action();
  }else{
    $controller->generateError(404,'Požadovaná stránka nebyla nalezena.');
  }
}else{
  header("HTTP/1.0 404 Not Found");
  exit('Požadovaná stránka nebyla nalezena.');
}

$controller->display();
