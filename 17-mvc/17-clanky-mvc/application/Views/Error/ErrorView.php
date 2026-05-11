<?php

namespace App\Views\Error;

use App\Library\View;

class ErrorView extends View {
  public ?int $errorCode = null;
  public string $errorHttpMessage = '';
  public string $errorMessage = '';

  /**
   *  Vypsání samotného generovaného obsahu stránky
   */
  public function display():void {
    echo '<h1>Error ';
    if($this->errorCode>0){
      echo $this->errorCode;
    }
    if(!empty($this->errorHttpMessage)){
      echo ' - '.$this->errorHttpMessage;
    }
    echo '</h1>';
    if($this->errorMessage){
      echo '<p>'.$this->errorMessage.'</p>';
    }
  }

}
