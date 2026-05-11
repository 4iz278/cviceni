<?php

namespace App\Views\Article;

use App\Library\View;

/**
 * Class ListView - view pro zobrazení přehledu článků
 */
class ListView extends View {
  public ?array $articles;

  /**
   * Funkce pro zobrazení view
   */
  public function display():void {
    echo '<h1>Přehled článků</h1>';
    
    if (empty($this->articles)){
      echo '<p>Nebyly nalezeny žádné články.</p>';
    }else{
      echo '<ul>';
      foreach($this->articles as $article){
        echo '<li><a href="'.BASE_URL.'/article/view?id='.urlencode($article['id']).'">'.htmlspecialchars($article['title']).'</a></li>';
      }
      echo '</ul>';
    }
  }
}