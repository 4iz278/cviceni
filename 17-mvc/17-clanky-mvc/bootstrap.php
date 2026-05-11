<?php

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

date_default_timezone_set("Europe/Prague"); 
session_start();

require_once __DIR__.'/application/config.php';
require_once __DIR__.'/vendor/autoload.php';

if (!empty($_REQUEST['controller'])){
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
try{
  $controllerName='\\App\\Controllers\\'.$controllerName;
  /** @var \App\Library\Controller $controller  */
  $controller=new $controllerName();
}catch(\Exception $e){
  $controller=new \App\Controllers\ErrorController();
  $controller->generateError(404,'Požadovaná stránka nebyla nalezena.');
}

if (method_exists($controller,$action)){
  $controller->$action();
}else{
  $controller->generateError(404,'Požadovaná stránka nebyla nalezena.');
}

$controller->display();
