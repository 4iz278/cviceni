<?php
namespace Blog\Views;

use Blog\Library\View;

/**
 * Class User_LoginView
 * @package Blog\Views
 */
class User_LoginView extends View{

  public string $formError;
  public string $email;

  /**
   *  Vypsání samotného generovaného obsahu stránky
   */
  public function display():void {
    echo '<h1>Přihlásit se...</h1>';
    if($this->formError){
      echo '<div class="errors">'.$this->formError.'</div>';
    }
    echo '<form action="'.BASE_URL.'/user/login" method="post">
            <table>
              <tr>
                <td><label for="email">E-mail:</label></td>
                <td><input type="text" name="email" id="email" value="'.htmlspecialchars($this->email ?? '').'" required /></td>
              </tr>
              <tr>
                <td><label for="password">Heslo:</label></td>
                <td><input type="password" id="password" name="password" value="" /></td>
              </tr>
            </table>  
            <div class="actionsDiv">
              <input type="submit" value="Přihlásit..." />
            </div>
          </form>';
  }
}
