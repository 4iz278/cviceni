<?php

namespace Blog\Model\Entities;

/**
 * Class User
 * @package Blog\Model\Entities
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property bool $active
 */
class User{

  const DEFAULT_REGISTERED_ROLE='registered';

  /**
   * Statická funkce pro zakódování uživatelského hesla
   * @param string $password
   * @return string
   */
  public static function encodePassword($password){
    //využíváme nám již známé funkce pro práci s hesly, v Nette bych doporučil využití třídy Nette\Security\Passwords
    return password_hash($password,PASSWORD_BCRYPT);
  }

  /**
   * Statická funkce pro ověření hesla vůči hashi
   * @param string $password
   * @param string $passwordHash
   * @return bool
   */
  public static function verifyPassword($password, $passwordHash){
    return password_verify($password,$passwordHash);
  }

  /**
   * Funkce pro ověření správnosti zadaného hesla
   * @param string $password
   * @return bool
   */
  public function isValidPassword($password){
    return self::verifyPassword($password,$this->password);
  }

  /**
   * Funkce vracející pole s daty pro ukládání v DB
   * @return array
   */
  public function getDataArr(){
    $result=[
      'name'=>@$this->name,
      'email'=>@$this->email,
      'password'=>@$this->password,
      'role'=>@$this->role,
      'active'=>@$this->active,
    ];
    if (!empty($this->id)){
      $result['id']=$this->id;
    }
    return $result;
  }
  
}