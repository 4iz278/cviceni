<?php

namespace Blog\Model;

use Nette\Security\Permission;
use \PDO;

/**
 * Class Authorizator
 * @package Blog\Model
 */
class Authorizator extends Permission{

  /**
   * Authorizator constructor - načte přehled všech rolí a oprávnění z databáze
   * @param PDO $pdo
   */
  public function __construct(PDO $pdo){
    //připravíme role
    $query=$pdo->prepare('SELECT * FROM roles;');
    $query->execute();
    $roles=$query->fetchAll(PDO::FETCH_CLASS);
    $rolesToAdd=[];
    foreach($roles as $role){
      $rolesToAdd[]=$role;
    }
    while(count($rolesToAdd)>0){
      foreach($rolesToAdd as $key=>$role){
        if ($role->parent_id!='' && !($this->hasRole($role->parent_id))){
          continue;
        }
        $this->addRole($role->id, $role->parent_id);
        unset($rolesToAdd[$key]);
      }
    }

    //připravíme zdroje a oprávnění k nim
    $query=$pdo->prepare('SELECT * FROM resources');
    $query->execute();
    $resources=$query->fetchAll(PDO::FETCH_CLASS);
    foreach($resources as $resource){
      //přidáme typy zdrojů
      if (!$this->hasResource($resource->resource)){
        $this->addResource($resource->resource);
      }
      //přidáme oprávnění k jednotlivým akcím
      if ($resource->action!=''){
        $this->allow($resource->role,$resource->resource,$resource->action);
      }else{
        $this->allow($resource->role,$resource->resource);
      }
    }
  }

}