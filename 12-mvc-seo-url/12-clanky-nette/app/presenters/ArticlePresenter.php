<?php

use Nette\Application\BadRequestException;

/**
 * Class ArticlePresenter - ukázka základního presenteru pro zobrazení článku/článků
 * @author Stanislav Vojíř
 */
class ArticlePresenter extends \Nette\Application\UI\Presenter{
  /** @var  ArticlesModel $articlesModel */
  private $articlesModel;

  /**
   * Akce pro zobrazení přehledu článků
   */
  public function renderList(){
    $this->template->articles=$this->articlesModel->findAll();
  }

  /**
   * Akce pro zobrazení jednoho článku
   * @param int $id
   * @throws BadRequestException
   */
  public function renderView($id){
    $article=$this->articlesModel->find($id);
    if ($article){
      $this->template->article=$article;
    }else{
      throw new BadRequestException('Požadovaný článek nebyl nalezen');
    }
  }

  /**
   * Funkce pro automatické vložení (injection) požadované služby, která je definována v config.neon
   * @param ArticlesModel $articlesModel
   */
  public function injectArticlesModel(ArticlesModel $articlesModel){
    $this->articlesModel=$articlesModel;
  }

}