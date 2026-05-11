<?php

namespace App\Controllers;

use App\Library\Controller;
use App\Model\ArticlesModel;
use App\Views\Article\ListView;
use App\Views\Article\ViewView;

/**
 * Class ArticleController - controller pro práci s články
 */
class ArticleController extends Controller {

  public function listAction():void {
    $articlesModel=ArticlesModel::getInstance();
    $this->setTitle('Přehled článků');
    /** @var ListView $view */
    $view=$this->getView();
    $view->articles=$articlesModel->findAll();
    $view->display();
  }

  /**
   * Akce pro zobrazení jednoho článku
   */
  public function viewAction():void {
    $articlesModel=ArticlesModel::getInstance();
    if (!($article=$articlesModel->find(@$_GET['id']))){
      $this->generateError(404, 'Požadovaný článek nebyl nalezen.');
    }
    $this->setTitle($article['title']);
    /** @var ViewView $view */
    $view=$this->getView();
    $view->article=$article;
    $view->display();
  }

}
