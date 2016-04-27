<?php

namespace Blog\Views;
use Blog\Library\CurrentUser;
use Blog\Library\View;
use Blog\Model\Entities\Article;
use Blog\Model\Entities\Category;

/**
 * Class Article_ListView - view pro zobrazení přehledu článků
 * @package Blog\Views
 * @property Category $category
 * @property Article[] $articles
 */
class Article_ListView extends View{

  /**
   * Funkce pro zobrazení view
   */
  function display(){
    /** @var CurrentUser $currentUser */
    $currentUser=CurrentUser::getInstance();
    echo '<h1>'.htmlspecialchars($this->category->name).'</h1>';

    if ($currentUser->hasAccess('article','add')){
      echo '<a href="'.BASE_URL.'/article/add?category='.$this->category->id.'">přidat článek...</a>';
    }

    if (!empty($this->articles)){
      foreach($this->articles as $article){
        echo '<article>
                <h2><a href="'.BASE_URL.'/article/show?id='.$article->id.'">'.htmlspecialchars($article->title).'</a></h2>
                '.$article->perex.'
              </article>';
      }
    }else{
      echo '<p>Nebyly nalezeny žádné články</p>';
    }

  }

}