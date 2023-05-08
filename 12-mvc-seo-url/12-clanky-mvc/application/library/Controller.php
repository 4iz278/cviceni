<?php

/**
 * Class Controller
 */
abstract class Controller{
  public string $layout='Default';
  public string $pageTitle='';
  public string $pageDescription='';
  private string $redirectUrl;

  /**
   *  Funkce vracející instanci view se zadaným jménem
   *  @return View
   */
  public function getView(string $viewName=''):View {
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
  public function setTitle(string $title=''):void {
    $this->pageTitle=$title;
  }

  /**
   *  Funkce pro nastavení description pro danou stránku
   */
  public function setDescription(string $description=''):void {
    $this->pageDescription=$description;
  }

  /**
   *  Funkce vracející title pro aktuální stránku
   */
  public function getTitle():string {
    return $this->pageTitle;
  }

  /**
   *  Funkce vracející description pro aktuální stránku
   */
  public function getDescription():string {
    return $this->pageDescription;
  }


  public function __construct(){
    ob_start();
  }

  /**
   *  Funkce pro nastavení přesměrování
   */
  public function setRedirect(string $redirectUrl):void {
    if(!strpos($redirectUrl, '://')){
      $this->redirectUrl=BASE_URL.$redirectUrl;
    }else{
      $this->redirectUrl=$redirectUrl;
    }
  }

  /**
   *  Funkce nastavující info zprávu pro zobrazení
   */
  public static function addInfoMessage(string $text, string $type='info'):void {
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
  public function getInfoMessages():array {
    if(isset($_SESSION['info_messages'])){
      $returnArr=$_SESSION['info_messages'];
    }else{
      $returnArr=[];
    }
    unset($_SESSION['info_messages']);
    return $returnArr;
  }


  /**
   *  Funkce pro zobrazení layoutu a vypsání obsahu
   */
  public function display():void {
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
  public function generateError(int $errorCode, string $text){
    $controller=new ErrorController();
    $controller->errorCode=$errorCode;
    $controller->errorMessage=$text;
    $controller->errorAction();
    $controller->display();
    exit();
  }
}

?>
