<?php
namespace Blog\Views\Homepage ;

use Blog\Library\View;

/**
 * Class DefaultView
 * @package Blog\Views\Homepage
 */
class DefaultView extends View{

  /**
   *  Vypsání samotného generovaného obsahu stránky
   */
  public function display():void {
    echo '<h1>Vítejte na ukázkovém webu, který je součástí podkladů předmětu 4iz278</h1>';
  }
  
}
