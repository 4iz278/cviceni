<?php
namespace Blog\Views;

use Blog\Library\View;

/**
 * Class Homepage_DefaultView
 * @package Blog\Views
 */
class Homepage_DefaultView extends View{

  /**
   *  Vypsání samotného generovaného obsahu stránky
   */
  public function display():void {
    echo '<h1>Vítejte na ukázkovém webu, který je součástí podkladů předmětu 4iz278</h1>';
  }
  
}
