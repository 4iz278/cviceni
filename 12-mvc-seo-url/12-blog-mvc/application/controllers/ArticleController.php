<?php

namespace Blog\Controllers;

use Blog\Library\CurrentUser;
use Blog\Model\ArticlesModel;
use Blog\Model\Entities\Article;
use Blog\Views\Article_AddView;
use Blog\Views\Article_EditView;
use Blog\Views\Article_ListView;
use Blog\Views\Article_ShowView;

/**
 * Class ArticleController - pro práci s články...
 * @package Blog\Controllers
 */
class ArticleController extends BaseController{
  public int $currentCategory;
  private string $formErrors = '';

  /**
   * Akce pro zobrazení článků v konkrétní kategorii
   */
  public function listAction():void {
    $category=$this->categoriesModel->find(@$_REQUEST['category']);
    if (!$category){
      $this->generateError(404,'Požadovaný obsah nebyl nalezen.');
      return;
    }
    $this->currentCategory=$category->id;
    $this->setTitle($category->name);

    /** @var ArticlesModel $articlesModel */
    $articlesModel=ArticlesModel::getInstance();

    /** @var Article_ListView $view */
    $view=$this->getView('list');
    $view->category=$category;
    $view->articles=$articlesModel->findAll($category->id);
    $view->display();
  }

  /**
   * Akce pro zobrazení jednoho článku
   */
  public function showAction():void {
    /** @var ArticlesModel $articlesModel */
    $articlesModel=ArticlesModel::getInstance();
    if (!($article=$articlesModel->find(intval(@$_REQUEST['id']),true))){
      $this->generateError(404,'Požadovaný obsah nebyl nalezen.');
      return;
    }

    $this->currentCategory=$article->category;
    $this->setTitle($article->title);
    /** @var Article_ShowView $view */
    $view=$this->getView('show');
    $view->article=$article;
    $view->display();
  }

  /**
   * Akce pro vytvoření článku
   */
  public function addAction():void {
    $article=new Article();
    if (!empty($_REQUEST['category']) && $this->categoriesModel->find($_REQUEST['category'])){
      $article->category=$_REQUEST['category'];
      $this->currentCategory=$_REQUEST['category'];
    }

    if (!empty($_POST) && $this->checkEditForm($article)){
      /** @var CurrentUser $currentUser */
      $currentUser=CurrentUser::getInstance();
      /** @var ArticlesModel $articlesModel */
      $articlesModel=ArticlesModel::getInstance();
      $article->author=$currentUser->id;
      if ($articlesModel->save($article)){
        $this->addInfoMessage('Článek byl úspěšně uložen.');
      }else{
        $this->addInfoMessage('Článek nebyl uložen.','error');
      }
      $this->setRedirect('/article/show?id='.$article->id);
    }

    $this->currentCategory=$article->category;
    $this->setTitle('Nový článek');
    /** @var Article_AddView $view */
    $view=$this->getView('add');
    $view->formError=$this->formErrors;
    $view->article=$article;
    $view->categories=$this->categories;
    if (!empty($this->currentCategory)){
      $view->currentCategory=$this->currentCategory;
    }
    $view->display();
  }

  /**
   * Akce pro úpravu článku
   */
  public function editAction():void {
    /** @var ArticlesModel $articlesModel */
    $articlesModel=ArticlesModel::getInstance();
    if (!($article=$articlesModel->find(intval(@$_REQUEST['id']),true))){
      $this->generateError(404,'Požadovaný obsah nebyl nalezen.');
      return;
    }

    if (!empty($_POST['id']) && $this->checkEditForm($article)){
      /** @var CurrentUser $currentUser */
      $currentUser=CurrentUser::getInstance();
      $article->author=$currentUser->id;
      if ($articlesModel->save($article)){
        $this->addInfoMessage('Článek byl úspěšně uložen.');
      }else{
        $this->addInfoMessage('Článek nebyl uložen.','error');
      }
      $this->setRedirect('/article/show?id='.$article->id);
    }

    $this->currentCategory=$article->category;
    $this->setTitle('Úprava článku');
    /** @var Article_EditView $view */
    $view=$this->getView('edit');
    $view->formError=$this->formErrors;
    $view->article=$article;
    $view->categories=$this->categories;
    $view->display();
  }

  /**
   * Funkce pro kontrolu platnosti vyplnění editačního formuláře
   * @param Article $article
   * @return bool
   */
  private function checkEditForm(Article &$article):bool {
    $errors='';
    $article->title=trim(@$_POST['title']);
    if (!$article->title){
      $errors.='<p>Je nutné zadat název článku.</p>';
    }
    $article->perex=trim(@$_POST['perex']);
    if (!$article->perex){
      $errors.='<p>Je nutné zadat perex článku.</p>';
    }
    $article->content=trim(@$_POST['content']);
    if (!$article->content){
      $errors.='<p>Je nutné zadat obsah článku.</p>';
    }
    $article->category=intval(@$_POST['category']);
    if (!$this->categoriesModel->find($article->category)){
      $errors.='<p>Je nutné vybrat kategorii.</p>';
    }
    $this->formErrors=$errors;
    return !$errors;
  }
}