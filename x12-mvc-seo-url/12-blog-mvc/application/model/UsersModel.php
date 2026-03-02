<?php

namespace Blog\Model;
use Blog\Library\Singleton;
use Blog\Model\Entities\User;
use \PDO;
use \PHPMailer;

/**
 * Class UsersModel - třída pro práci s uživateli
 * @package Blog\Model
 */
class UsersModel extends BaseModel{
  use Singleton;

  /**
   * Funkce pro nalezení všech uživatelů
   * @return User[]
   */
  public function findAll(){
    $query=self::$pdo->prepare('SELECT * FROM users');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_CLASS,__NAMESPACE__.'\Entities\User');
  }

  /**
   * Funkce pro nalezení jednoho uživatele podle ID
   * @param int $id
   * @return User|bool
   */
  public function findById(int $id):User|bool {
    $query=self::$pdo->prepare('SELECT * FROM users WHERE id=:id LIMIT 1;');
    $query->execute([':id'=>$id]);
    return $query->fetchObject(__NAMESPACE__.'\Entities\User');
  }

  /**
   * Funkce pro nalezení uživatele podle e-mailu
   * @param string $email
   * @return User
   */
  public function findByEmail(string $email):User {
    $query=self::$pdo->prepare('SELECT * FROM users WHERE email=:email LIMIT 1;');
    $query->execute([':email'=>$email]);
    return $query->fetchObject(__NAMESPACE__.'\Entities\User');
  }

  /**
   * Funkce pro smazání jednoho článku
   * @param User|int $id
   * @return bool
   */
  public function delete(User|int $id):bool {
    if ($id instanceof User){
      $id=$id->id;
    }
    $query=self::$pdo->prepare('DELETE FROM users WHERE id=:id LIMIT 1;');
    return (bool)$query->execute([':id'=>$id]);
  }

  /**
   * @param User $user
   * @return bool
   */
  public function save(User $user):bool {
    $dataArr=$user->getDataArr();
    $paramsArr=[];
    if (@$user->id>0){
      //updatujeme existující uživatele
      $sql='';
      foreach($dataArr as $key=>$value){
        if ($key=='id'){continue;}
        $sql.=($sql!=''?',':'').' '.$key.'=:'.$key;
        $paramsArr[':'.$key]=$value;
      }
      $sql='UPDATE users SET '.$sql.' WHERE id=:id LIMIT 1;';
      $paramsArr[':id']=$user->id;
      $query=self::$pdo->prepare($sql);
      $result=$query->execute($paramsArr);
    }else{
      //insert nového uživatele
      $sql='INSERT INTO users (';
      $sql.=implode(',',array_keys($dataArr));
      $sql.=')VALUES(';
      foreach($dataArr as $key=>$value){
        $paramsArr[':'.$key]=$value;
      }
      $sql.=implode(',',array_keys($paramsArr));
      $sql.=')';
      $query=self::$pdo->prepare($sql);
      $result=$query->execute($paramsArr);
      $user->id=self::$pdo->lastInsertId('users');
    }
    return (bool)$result;
  }

  /**
   * Funkce pro odeslání potvrzovacího e-mailu po registraci uživatele
   * @param User $user
   */
  public function sendRegistrationMail(User $user):void {
    $mailer=new PHPMailer();
    $mailer->isSendmail();//nastavení, že se mail má odeslat přes sendmail
    $mailer->addAddress($user->email);
    $mailer->setFrom("xname@eso.vse.cz");
    $mailer->CharSet='utf-8';
    $mailer->Subject='Registrace na webu...';
    $mailer->msgHTML('<p>Byli jste úspěšně zaregistrováni, pro přihlášení využijte e-mail <strong>'.$user->email.'</strong></p>');
    $mailer->send();
  }
  
}