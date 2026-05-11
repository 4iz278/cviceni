<?php

namespace App\Views\Article;

use App\Library\View;

/**
 * Class ViewView - view pro zobrazení jednoho článku
 */
class ViewView extends View {
  public array $article;

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