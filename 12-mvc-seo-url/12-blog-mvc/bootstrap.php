<?php
date_default_timezone_set("Europe/Prague"); 
session_start();

require_once './application/config.php';
require_once './application/library/Autoloader.php';

\Blog\Library\Autoloader::registerSplAutoload();

if (@$_REQUEST['controller']!=''){
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
if(\Blog\Library\Autoloader::controllerExists($controllerName)){
  $controllerName='\\Blog\\Controllers\\'.$controllerName;
  /** @var \Blog\Library\Controller $controller  */
  $controller=new $controllerName();
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
}else{
  $controller=new \Blog\Controllers\ErrorController();
  $controller->generateError(404,'Požadovaná stránka nebyla nalezena.');
}

$controller->display();
