<?php

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

date_default_timezone_set("Europe/Prague"); 
session_start();

require_once __DIR__.'/application/config.php';
require_once __DIR__.'/vendor/autoload.php';

if (!empty($_REQUEST['controller'])){
  $controllerName=ucfirst(trim($_REQUEST['controller'])).'Controller';
}else{
  $controllerName='HomepageController';
  $_REQUEST['controller']='homepage';
}
if (isset($_REQUEST['action'])){
  $action=trim($_REQUEST['action']).'Action';
}else{
  $action='defaultAction';
}

$currentUser=\Blog\Library\CurrentUser::getInstance();

//overeni existence controlleru a jeho spusteni
//vytvoření controlleru a kontrola, jestli existuje požadovaná metoda
try{
  $controllerName='\\Blog\\Controllers\\'.$controllerName;
  /** @var \Blog\Library\Controller $controller  */
  $controller=new $controllerName();
}catch(\Exception $e){
  $controller=new \Blog\Controllers\ErrorController();
  $controller->generateError(404,'Požadovaná stránka nebyla nalezena.');
}

if (method_exists($controller,$action)){
  //kontrola přístupu
  if ($currentUser->hasAccess($_REQUEST['controller'], $_REQUEST['action']??'')){
    $controller->$action();
  }elseif(!$currentUser->isLoggedIn()){
    //zobrazime vyzvu pro prihlaseni
    $controller->addInfoMessage('Pro zobrazení požadovaného modulu se musíte přihlásit.');
    $controller->setRedirect(BASE_URL.'/user/login');
  }else{
    //zobrazime chybu o tom, ze uzivatel nema opravneni stranku zobrazit
    $controller->generateError(401,'Nemáte oprávnění k zobrazení požadovaného modulu.');
  }
}else{
  $controller->generateError(404,'Požadovaná stránka nebyla nalezena.');
}

$controller->display();
