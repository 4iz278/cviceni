<?php

namespace App\Controllers;

/**
 * Class HomepageController - controller pro zajištění funkcionality homepage
 */
class HomepageController extends \App\Library\Controller {
  /**
   *  Funkce pro vypsání HP
   */
  public function defaultAction():void {
    $this->setRedirect('/article/list');
  }


}
