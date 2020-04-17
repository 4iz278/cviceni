<?php
  namespace Blog\Views;
  use Blog\Library\View;

  /**
   * @property int $errorCode
   * @property string $errorHttpMessage
   * @property string $errorMessage
   */
  class Error_ErrorView extends View{
    /**
     *  Vypsání samotného generovaného obsahu stránky
     */
    public function display(){
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
