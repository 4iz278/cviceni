<?php

namespace Blog\Layouts;

use Blog\Library\Controller;
use Blog\Library\CurrentUser;
use Blog\Model\Entities\Category;

/**
 * Class DefaultLayout - výchozí layout aplikace
 * @package Blog\Layouts
 */
class DefaultLayout{
  /** @var  Controller $controller */
  public $controller;

  /**
   *  Funkce pro vykreslení obsahu stránky
   */
  public function display($content){
    $currentUser=CurrentUser::getInstance();
    $title=$this->controller->getTitle();
    echo '<!DOCTYPE html>
          <html>
            <head>
              <meta charset="utf-8" />
              <title>'.(!empty($title) ? htmlspecialchars($title).' | ' : '').'Ukázkový jednoduchý blog</title>
              <link rel="stylesheet" href="'.BASE_URL.'/resources/css/main.css" type="text/css" />
              <link rel="stylesheet" href="'.BASE_URL.'/resources/css/nette.css" type="text/css" />
            </head>
            <body>
              <header>
                <h1><a href="'.BASE_URL.'">Jednoduchý blog</a></h1>
                <div id="currentUser">';
    if($currentUser->isLoggedIn()){
      echo 'Přihlášený uživatel: <strong>'.$currentUser->name.'</strong> ('.$currentUser->email.')
                          <a href="'.BASE_URL.'/user/logout">Odhlásit se...</a>';
    }else{
      echo '<a href="'.BASE_URL.'/user/login">Přihlásit se...</a>';
    }
    echo '      </div>
              </header>';
    #region nav
    if (!empty($this->controller->categories)){
      echo '<nav><ul>';
      foreach ($this->controller->categories as $categoryItem){
        echo '<li><a href="'.BASE_URL.'/article/list?category='.$categoryItem->id.'" '.(!empty($this->controller->currentCategory) && $this->controller->currentCategory==$categoryItem->id?'class="active"':'').'>'.htmlspecialchars($categoryItem->name).'</a></li>';
      }
      echo '</ul></nav>';
    }
    #endregion nav
    echo '    <section id="main">';

    #region info zprávy
    $infoMessages=$this->controller->getInfoMessages();
    if (!empty($infoMessages['info'])){
      echo '<div class="flash"><ul>';
      foreach ($infoMessages['info'] as $infoMessage) {
        echo ' <li>'.$infoMessage.'</li>';
      }
      echo '  </ul></div>';
    }
    if (!empty($infoMessages['error'])){
      echo '<div class="flash error"><ul>';
      foreach ($infoMessages['error'] as $infoMessage) {
        echo ' <li>'.$infoMessage.'</li>';
      }
      echo '  </ul></div>';
    }
    #endregion info zprávy


    echo $content;

    echo '    </section>';
    echo '<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
          <script type="text/javascript" src="'.BASE_URL.'/resources/js/tinymce/tinymce.min.js"></script>
          <script type="text/javascript" src="'.BASE_URL.'/resources/js/tinymce/jquery.tinymce.min.js"></script>
          <script type="text/javascript" src="'.BASE_URL.'/resources/js/main.js"></script>';

    echo '</body></html>';
  }
}