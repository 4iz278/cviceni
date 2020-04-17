<?php

namespace Blog\Presenters;

use Blog\Model\CategoriesModel;
use Blog\Model\Entities\Article;
use Nette\Application\BadRequestException;
use Blog\Model\ArticlesModel;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\SubmitButton;

/**
 * Class ArticlePresenter - ukázka základního presenteru pro zobrazení článku/článků
 * @author Stanislav Vojíř
 */
class ArticlePresenter extends BasePresenter{
  /** @var  ArticlesModel $articlesModel */
  private $articlesModel;

  /**
   * Akce pro zobrazení přehledu článků
   * @param int $category;
   */
  public function renderList($category){
    $this->template->category=$this->categoriesModel->find($category);
    $this->template->articles=$this->articlesModel->findAll($category);
  }

  /**
   * Akce pro zobrazení jednoho článku
   * @param int $id
   * @throws BadRequestException
   */
  public function renderShow($id){
    $article=$this->articlesModel->find($id,true);
    if ($article){
      $this->template->article=$article;
    }else{
      throw new BadRequestException('Požadovaný článek nebyl nalezen');
    }
  }

  /**
   * Akce pro přidání nového článku
   * @param int|null $category=null
   */
  public function actionAdd($category=null){
    if ($category && $this->categoriesModel->find($category)){
      $form=$this->getComponent('editForm');
      $form->setDefaults(['category'=>$category]);
    }
  }

  /**
   * Akce pro úpravu existujícího článku
   * @param int $id
   * @throws BadRequestException
   */
  public function actionEdit($id){
    if (!$article=$this->articlesModel->find($id)){
      throw new BadRequestException('Požadovaný článek nebyl nalezen.');
    }
    $form=$this->getComponent('editForm');
    $form->setDefaults([
      'id'=>$article->id,
      'title'=>$article->title,
      'perex'=>$article->perex,
      'content'=>$article->content,
      'category'=>$article->category
    ]);
  }

  /**
   * Funkce připravující formulář pro zadání nového/úpravu existujícího článku
   * @return Form
   */
  public function createComponentEditForm(){
    $form = new Form();
    $form->addHidden('id');
    $form->addText('title','Název článku:',null,200)
      ->setRequired('Je nutné zadat název článku');
    $form->addTextArea('perex','Perex:')
      ->setRequired('Je nutné zadat perex článku.')
      ->setAttribute('class','wysiwyg');
    $form->addTextArea('content','Obsah článku:')
      ->setRequired('Je nuté zadat obsah článku.')
      ->setAttribute('class','wysiwyg');
    $categories=$this->categoriesModel->findAll();
    $categoriesArr=[];
    foreach($categories as $category){
      $categoriesArr[$category->id]=$category->name;
    }
    $form->addSelect('category','Kategorie',$categoriesArr)
      ->setPrompt('--vyberte--')
      ->setRequired('Je nutné vybrat kategorii.');
    $form->addSubmit('save','uložit')
      ->onClick[]=function(SubmitButton $button){
      //funkce po úspěšném odeslání formuláře
      $data=$button->form->getValues(true);
      if ($data['id']>0){
        //aktualizujeme existující článek
        $article=$this->articlesModel->find($data['id']);
        $article->title=$data['title'];
        $article->perex=$data['perex'];
        $article->content=$data['content'];
        $article->category=$data['category'];
        $article->author=$this->user->id;
        $result=$this->articlesModel->save($article);
      }else{
        //zobrazíme nový článek
        $article=new Article();
        $article->title=$data['title'];
        $article->perex=$data['perex'];
        $article->content=$data['content'];
        $article->category=$data['category'];
        $article->author=$this->user->id;
        $result=$this->articlesModel->save($article);
      }
      if ($result){
        $this->flashMessage('Článek byl úspěšně uložen.');
      }else{
        $this->flashMessage('Článek se nepodařilo uložit.','error');
      }
      if ($article->id>0){
        $this->redirect('Article:show',['id'=>$article->id]);
      }else{
        $this->redirect('Homepage:default');
      }
    };
    $form->addSubmit('storno','zrušit')
      ->setValidationScope([])
      ->onClick[]=function(SubmitButton $button){
      //funkce po kliknutí na tlačítko pro zrušení
      $data=$button->form->getValues(true);
      if ($data['id']>0){
        $this->redirect('Article:show',['id'=>$data['id']]);//přesměrování na zobrazení daného článku
      }elseif($data['category']>0){
        $this->redirect('Article:list',['category'=>$data['category']]);//přesměrování na zobrazení kategorie
      }else{
        $this->redirect('Homepage:default');
      }
    };
    return $form;
  }
  
  
  #region injections - metody zajišťující automatické načtení potřebných služeb
  /**
   * Funkce pro automatické vložení (injection) požadované služby, která je definována v config.neon
   * @param ArticlesModel $articlesModel
   */
  public function injectArticlesModel(ArticlesModel $articlesModel){
    $this->articlesModel=$articlesModel;
  }
  #endregion injections
}