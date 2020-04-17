<?php

namespace Blog\Library;
use Blog\Model\AclModel;
use Blog\Model\Entities\User;
use Blog\Model\UsersModel;

/**
 * Třída pro práci s aktuálně přihlášeným uživatelem
 */
class CurrentUser{
  /** @var  CurrentUser $instance */
  private static $instance;
  /** @var  string $name */
  public $name;
  /** @var  string $email */
  public $email;
  /** @var int $id */
  public $id;

  /**
   *  Funkce pro připravení instance currentUser po přihlášení uživatele
   */
  /**
   * @param User $user
   * @return CurrentUser
   */
  public static function login(User $user){
    $newUser=new CurrentUser();
    $newUser->name=@$user->name;
    $newUser->email=@$user->email;
    $newUser->id=@$user->id;
    self::$instance=&$newUser;
    session_regenerate_id();

    $_SESSION['user']=['name'=>$newUser->name,'id'=>$newUser->id,'email'=>$newUser->email];

    return self::$instance;
  }

  /**
   *  Funkce pro odhlášení uživatele
   */
  public static function logout(){
    unset($_SESSION['user']);
    session_regenerate_id();
    self::$instance=null;
    return self::getInstance();
  }

  /**
   *  Funkce pro ověření, jestli má uživatel přístup ke konkrétní části aplikace
   */
  public function hasAccess($controller,$action=''){//FIXME
    /** @var UsersModel $usersModel */
    $usersModel=UsersModel::getInstance();
    /** @var AclModel $aclModel */
    $aclModel=AclModel::getInstance();
    
    $user=$usersModel->findById($this->id);
    if (($user)&&($user->id!=0)){
      $role=$user->role;
    }else{
      $role='guest';
    }

    return $aclModel->isAllowed($role,$controller,$action);
  }

  /**
   * Funkce pro kontrolu, jestli je uživatel přihlášen
   */
  public function isLoggedIn(){
    return ($this->id>0);
  }

  /**
   * CurrentUser constructor.
   */
  private function __construct(){
    if (!is_array($_SESSION['user'])){
      $_SESSION['user']=['name'=>'','email'=>'','id'=>0];
    }
    $this->name=@$_SESSION['user']['name'];
    $this->id=@$_SESSION['user']['id'];
    $this->email=@$_SESSION['user']['email'];
  }

  /**
   * Metoda pro Singleton
   * @return CurrentUser
   */
  public static function getInstance(){
    if (!isset(self::$instance)){
      self::$instance=new CurrentUser();
    }
    return self::$instance;
  }

}