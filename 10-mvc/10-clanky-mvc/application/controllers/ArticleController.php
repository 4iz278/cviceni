<?php

/**
 * Class ArticleController - controller pro práci s články
 */
class ArticleController extends Controller{

  public function listAction(){
    $articlesModel=ArticlesModel::getInstance();
    $this->setTitle('Přehled článků');
    $view=$this->getView();
    $view->articles=$articlesModel->findAll();
    $view->display();
  }

  /**
   * Akce pro zobrazení jednoho článku
   */
  public function viewAction(){
    $articlesModel=ArticlesModel::getInstance();
    if (!($article=$articlesModel->find(@$_GET['id']))){
      $this->generateError(404, 'Požadovaný článek nebyl nalezen.');
      return;
    }
    $this->setTitle($article['title']);
    $view=$this->getView();
    $view->article=$article;
    $view->display();
  }

}
