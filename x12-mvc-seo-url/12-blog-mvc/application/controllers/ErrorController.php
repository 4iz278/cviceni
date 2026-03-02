<?php
namespace Blog\Controllers;

use Blog\Views\Error_ErrorView;

/**
 * Class ErrorController
 * @package Blog\Controllers
 */
class ErrorController extends BaseController{

  public int $errorCode;
  public string $errorMessage;

  public function errorAction():void {
    if($this->errorCode>0){
      $errorHttpMessage=self::getErrorMessage($this->errorCode);
      header('HTTP/1.0 '.$this->errorCode.' '.$errorHttpMessage);

    }else{
      $errorHttpMessage=null;
    }

    $title='Error '.(($this->errorCode>0)?$this->errorCode:'');

    $this->setTitle($title);
    /** @var Error_ErrorView $view */
    $view=$this->getView('error');
    $view->errorCode=$this->errorCode;
    $view->errorMessage=$this->errorMessage;
    $view->errorHttpMessage=@$errorHttpMessage;
    $view->display();
  }

  public function notFoundAction():void {
    $this->errorCode=404;
    $this->errorMessage='Požadovaný soubor nebyl nalezen.';
    $this->errorAction();
  }

  private static function getErrorMessage(int $errorCode):?string {
    $errorMessages= [
      400=>'Bad request',
      401=>'Unauthorized',
      402=>'Payment Required',
      403=>'Forbidden',
      404=>'Not Found',
      405=>'Method Not Allowed',
      406=>'Not Acceptable',
      408=>'Request Timeout',
      409=>'Conflict',
      410=>'Gone',
      500=>'Internal Server Error',
      501=>'Not Implemented',
      503=>'Service Unavailable'
    ];
    return isset($errorMessages[$errorCode])?$errorMessages[$errorCode]:null;
  }

}
