<?php

/**
 * Class Controller
 */
abstract class Controller{
  public $layout='Default';
  public $pageTitle='';
  public $pageDescription='';
  private $redirectUrl;

  /**
   *  Funkce vracející instanci view se zadaným jménem
   *  @return View
   */
  public function getView($viewName=''){
    if($viewName==''){
      $viewName=$_REQUEST['action'];
    }
    $controllerName=get_called_class();
    $controllerName=substr($controllerName, 0, strlen($controllerName)-10);

    $viewName=$controllerName.'_'.ucfirst($viewName).'View';
    return new $viewName();
  }

  /**
   *  Funkce pro nastavení title pro danou stránku
   */
  public function setTitle($title=''){
    $this->pageTitle=$title;
  }

  /**
   *  Funkce pro nastavení description pro danou stránku
   */
  public function setDescription($description=''){
    $this->pageDescription=$description;
  }

  /**
   *  Funkce vracející title pro aktuální stránku
   */
  public function getTitle(){
    return $this->pageTitle;
  }

  /**
   *  Funkce vracející description pro aktuální stránku
   */
  public function getDescription(){
    return $this->pageDescription;
  }


  public function __construct(){
    ob_start();
  }

  /**
   *  Funkce pro nastavení přesměrování
   */
  public function setRedirect($redirectUrl){
    if(!strpos($redirectUrl, '://')){
      $this->redirectUrl=BASE_URL.$redirectUrl;
    }else{
      $this->redirectUrl=$redirectUrl;
    }
  }

  /**
   *  Funkce nastavující info zprávu pro zobrazení
   */
  public static function addInfoMessage($text, $type='info'){
    if(!is_array($_SESSION['info_messages'])){
      $_SESSION['info_messages']=array();
    }
    if(!is_array($_SESSION['info_messages'][$type])){
      $_SESSION['info_messages'][$type]=array();
    }
    $_SESSION['info_messages'][$type][]=$text;
  }

  /**
   *  Funkce vracející info zprávy pro zobrazení
   */
  public function getInfoMessages(){
    if(isset($_SESSION['info_messages'])){
      $returnArr=$_SESSION['info_messages'];
    }else{
      $returnArr=array();
    }
    unset($_SESSION['info_messages']);
    return $returnArr;
  }


  /**
   *  Funkce pro zobrazení layoutu a vypsání obsahu
   */
  public function display(){
    if(isset($this->redirectUrl)){
      header('Location: '.$this->redirectUrl);
      return;
    }

    if($this->layout!=''){
      $layout=$this->layout.'Layout';
      $layout=new $layout();
      $layout->controller=&$this;
      $content=ob_get_contents();
      ob_end_clean();
      $layout->display($content);
    }else{
      ob_end_flush();
    }
  }

  /**
   *  Funkce pro vygenerování chybové stránky
   */
  public function generateError($errorCode, $text){
    $controller=new ErrorController();
    $controller->errorCode=$errorCode;
    $controller->errorMessage=$text;
    $controller->errorAction();
    $controller->display();
    exit();
  }
}

?>
