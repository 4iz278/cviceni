<?php

namespace Blog\Presenters;

use Blog\Model\CategoriesModel;
use Nette;

/**
 * Base presenter obsahující funkce sdílené dalšími presentery
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter{
  protected CategoriesModel $categoriesModel;

  /**
   * Funkce volaná před vykreslováním šablony
   */
  public function beforeRender(){
    $this->template->categories=$this->categoriesModel->findAll();
  }

  public function startup(){
    $user=$this->getUser();
    $action=$this->request->parameters['action']?$this->request->parameters['action']:'';
    if (!$user->isAllowed(strtolower($this->request->presenterName),strtolower($action))){
      if ($user->isLoggedIn()){
        throw new Nette\Application\ForbiddenRequestException('Nemáte oprávnění přistupovat ke zvolené stránce!');
      }else{
        $this->flashMessage('Pro přístup ke zvolené stránce se nejprve musíte přihlásit!','warn');
        $this->redirect('User:login',['backlink'=>$this->storeRequest()]);
      }
    }
    parent::startup();
  }
  
  
  #region injections
  public function injectCategoriesModel(CategoriesModel $categoriesModel):void {
    $this->categoriesModel=$categoriesModel;
  }
  #endregion injections
}
