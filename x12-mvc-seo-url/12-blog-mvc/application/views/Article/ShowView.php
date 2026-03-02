<?php

namespace Blog\Views;
use Blog\Library\CurrentUser;
use Blog\Library\View;
use Blog\Model\Entities\Article;

/**
 * Class Article_ShowView
 * @package Blog\Views
 */
class Article_ShowView extends View{
  public Article $article;

  /**
   * Funkce pro zobrazení view
   */
  public function display():void {
    /** @var CurrentUser $currentUser */
    $currentUser=CurrentUser::getInstance();
    echo '<article>';
    echo '<h1>'.htmlspecialchars($this->article->title).'</h1>';

    if ($currentUser->hasAccess('article','edit')){
      echo '<a href="'.BASE_URL.'/article/edit?id='.$this->article->id.'">upravit článek</a>';
    }
    echo '<dl class="articleInfo">
            <dt>Kategorie:</dt>
            <dd><a href="'.BASE_URL.'/article/list?category='.$this->article->category.'">'.htmlspecialchars($this->article->categoryName).'</a></dd>
            <dt>Autor:</dt>
            <dd>'.htmlspecialchars($this->article->authorName).'</dd>
          </dl>';

    echo $this->article->getFullContent();
    echo '</article>';
  }
}