<?php

/**
 * Class Article_ViewView - view pro zobrazení jednoho článku
 * @property array $article
 */
class Article_ViewView extends View{

  /**
   * Funkce pro zobrazení view
   */
  public function display():void {
    echo '<a href="'.BASE_URL.'/article/list">Zpět na přehled článků</a>';

    echo '<h1>'.$this->article['title'].'</h1>';
    echo $this->article['perex'];
    echo $this->article['content'];
  }
}