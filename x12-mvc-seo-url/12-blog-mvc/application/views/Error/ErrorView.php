<?php
  namespace Blog\Views;
  use Blog\Library\View;

class Error_ErrorView extends View{
  public int $errorCode;
  public string $errorHttpMessage;
  public string $errorMessage;

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
