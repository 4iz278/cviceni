<?php
namespace Blog\Controllers;

/**
 * Class HomepageController
 * @package Blog\Controllers
 */
class HomepageController extends BaseController{

  /**
   *  Funkce pro vypsání HP
   */
  public function defaultAction():void {
    //jde o anonyma
    $view=$this->getView('default');
    $view->display();
  }
  
}
