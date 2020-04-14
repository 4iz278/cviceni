<?php

/**
 * Class HomepagePresenter - presenter pro zobrazení homepage
 */
class HomepagePresenter extends \Nette\Application\UI\Presenter{

  /**
   * Výchozí akce
   */
  public function actionDefault(){
    //funkce pro přesměrování - parametrem je jméno presenteru, za dvojtečkou je požadovaná akce (URL z toho udělá framework)
    $this->redirect('Article:list');
  }

}