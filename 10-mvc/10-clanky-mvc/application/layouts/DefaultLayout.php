<?php

  /**
   * Class DefaultLayout
   */
  class DefaultLayout{
    /** @var  Controller $controller */
    public $controller;

    /**
     *  Funkce pro vykreslení obsahu stránky
     */         
    public function display($content){
      echo '<!DOCTYPE html>
            <html >
            <head>
              <meta charset="utf-8" />
              <title>'.$title=$this->controller->getTitle();if ($title!=''){echo $title.' - ';}echo 'VYUKOVA NASTENKA</title>
            </head>
            <body>            
            <div id="contentDiv">';
              /*VYPSANI INFO ZPRAV*/
              $infoMessages=$this->controller->getInfoMessages();
              if (!empty($infoMessages['info'])){
                echo '<div class="infoBlock">
                              <ul>';
                foreach ($infoMessages['info'] as $infoMessage) {
                  echo ' <li>'.$infoMessage.'</li>';
                }
                echo '  </ul>
                            </div>';
              }
              if (!empty($infoMessages['error'])){
                echo '<div class="errorBlock">
                              <ul>';
                foreach ($infoMessages['error'] as $infoMessage) {
                  echo ' <li>'.$infoMessage.'</li>';
                }
                echo '  </ul>
                            </div>';
              }
              /*--VYPSANI INFO ZPRAV*/

              /*VYPSANI OBSAHU*/
              echo $content;
              /*--VYPSANI OBSAHU*/
     echo ' </div>            
            </body>
            </html>';
    }
  }