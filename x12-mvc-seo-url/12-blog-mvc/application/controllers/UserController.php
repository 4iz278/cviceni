<?php
namespace Blog\Controllers;

use Blog\Library\CurrentUser;
use Blog\Model\Entities\User;
use Blog\Model\UsersModel;
use Blog\Views\User_LoginView;
use Blog\Views\User_RegisterView;

/**
 * Class UserController
 * @package Blog\Controllers
 */
class UserController extends BaseController{
  private string $formErrors='';
  private UsersModel $usersModel;

  /**
   * Akce pro přihlášení uživatele
   */
  public function loginAction():void {
    $this->setTitle('Přihlásit se...');
    $currentUser=CurrentUser::getInstance();
    if($currentUser->isLoggedIn()){
      $this->setRedirect(BASE_URL);
      return;
    }
    $prihlaseno=false;
    $email=$_POST['email'] ?? '';
    //exit(var_dump($_POST));
    if($email!=''){
      //máme zaslané přihlašovací uživatele
      /** @var UsersModel $usersModel */
      $usersModel=UsersModel::getInstance();
      $user=$usersModel->findByEmail($email);
      if($user){
        //kontrola, jestli bylo spravne zadano heslo
        if($user->isValidPassword(@$_POST['password'])){
          //uzivatel je přihlášen
          CurrentUser::login($user);
          $this->setRedirect(self::getLoginReferer() ?? BASE_URL);
        }else{
          $this->formErrors='<p>Chybně zadané uživatelské jméno či heslo</p>';
        }
      }else{
        $this->formErrors='<p>Chybně zadané uživatelské jméno či heslo</p>';
      }
    }
    if(!$prihlaseno){
      //máme zobrazit přihlašovací formulář
      ///pokud máme nastavený referer stránky, ze které bylo vyvoláno přihlášení, tak ho nastavíme pro zpětné přesměrování
      if(isset($_SERVER['HTTP_REFERER'])){
        if(!self::getLoginReferer()){
          self::setLoginReferer($_SERVER['HTTP_REFERER']);
        }
      }
      /** @var User_LoginView $view */
      $view=$this->getView('login');
      $view->email=$email;
      $view->formError=@$this->formErrors;
      $view->display();
    }
  }

  /**
   * Akce pro odhlášení uživatele
   */
  public function logoutAction():void {
    CurrentUser::logout();
    $this->setRedirect(BASE_URL);
  }

  /**
   * Akce pro registraci uživatele
   */
  public function registerAction():void {
    $this->setTitle('Zaregistrovat se...');
    if (!empty($_POST)){
      $user=new User();
      if ($this->checkRegisterForm($user)){
        //formulář je v pořádku - zaregistrujeme uživatele
        if ($this->usersModel->save($user)){
          $this->usersModel->sendRegistrationMail($user);
          CurrentUser::login($user);
          $this->addInfoMessage('Registrace byla úspěšně dokončena.');
        }else{
          $this->addInfoMessage('Uživatelský účet nebyl vytvořen.','error');
        }
        $this->setRedirect(BASE_URL);
      }
    }

    /** @var User_RegisterView $view */
    $view=$this->getView('register');
    $view->email=$_REQUEST['email'] ?? '';
    $view->name=$_REQUEST['name'] ?? '';
    $view->formError=@$this->formErrors;
    $view->display();
  }

  /**
   * Funkce pro kontrolu dat odeslaných v rámci registračního formuláře
   * @param User $user
   * @return  bool
   */
  private function checkRegisterForm(User &$user){
    $user->name=trim($_POST['name'] ?? '');
    $user->email=trim($_POST['email'] ?? '');
    $errors='';
    if (empty($user->email) ||(!filter_var($user->email, FILTER_VALIDATE_EMAIL) !== false)){
      $errors.='<p>Musíte zadat platnou e-mailovou adresu.</p>';
    }else{
      if ($this->usersModel->findByEmail($user->email)){
        $errors.='<p>Účet s danou e-mailovou adresou již existuje.</p>';
      }
    }
    if (strlen($_POST['password'] ?? '')<=3){
      $errors.='<p>Heslo musí mit minimálně 4 znaky.</p>';
    }
    if (!empty($_POST['password']) && ($_POST['password']!=($_POST['password2']??''))){
      $errors.='<p>Zadaná hesla se neshodují.</p>';
    }
    $this->formErrors.=$errors;
    return ($errors=='');
  }

  /**
   * Statická funkce pro nastavení URL pro zpětné přesměrování po přihlášení
   */
  public static function setLoginReferer(string $returnUrl):void {
    $_SESSION['LOGIN_REFERER']=$returnUrl;
  }

  /**
   * Statická funkce vracející info pro zpětné přesměrování po přihlášení
   */
  public static function getLoginReferer():?string {
    if (!empty($_SESSION['LOGIN_REFERER'])){
      $loginReferer=$_SESSION['LOGIN_REFERER'] ;
      unset($_SESSION['LOGIN_REFERER']);
      return $loginReferer;
    }
    return null;
  }

  /**
   * UserController constructor
   */
  public function __construct(){
    parent::__construct();
    $this->usersModel=UsersModel::getInstance();
  }
}

