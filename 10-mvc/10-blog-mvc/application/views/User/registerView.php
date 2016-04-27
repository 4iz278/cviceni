<?php
namespace Blog\Views;

use Blog\Library\View;

/**
 * Class User_RegisterView
 * @package Blog\Views
 * @property string $formError
 * @property string $name
 * @property string $email
 */
class User_RegisterView extends View{
  /**
   *  Vypsání samotného generovaného obsahu stránky
   */
  public function display(){
    echo '<h1>Zaregistrovat se...</h1>';
    if($this->formError){
      echo '<div class="errors">'.$this->formError.'</div>';
    }
    echo '<form action="'.BASE_URL.'/user/login" method="post">
            <table>
              <tr>
                <td><label for="name">Jméno a příjmení:</label></td>
                <td><input type="text" name="name" id="name" value="'.htmlspecialchars(@$this->name).'" required /></td>
              </tr>
              <tr>
                <td><label for="email">E-mail:</label></td>
                <td><input type="text" name="email" id="email" value="'.htmlspecialchars(@$this->email).'" required /></td>
              </tr>
              <tr>
                <td><label for="password">Heslo:</label></td>
                <td><input type="password" id="password" name="password" value="" /></td>
              </tr>
              <tr>
                <td><label for="password2">Potvrzení hesla:</label></td>
                <td><input type="password" id="password2" name="password2" value="" /></td>
              </tr>
            </table>  
            <div class="actionsDiv">
              <input type="submit" value="Zaregistrovat se..." />
            </div>
          </form>';
  }
}
