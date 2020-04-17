<?php

namespace Blog\Model;
use Blog\Library\Singleton;
use \PDO;

/**
 * Class AclModel
 * @package Blog\Model
 */
class AclModel extends BaseModel{
  use Singleton;

  /**
   * @param string $role
   * @return string[]
   */
  public function findInheritedRoles($role){
    $result=[];
    $query=self::$pdo->prepare('SELECT * FROM roles WHERE `role`=:role;');
    $query->execute([':role'=>$role]);
    if ($resultRole=$query->fetchObject()){
      $result[]=$role;
      if ($role->parent_role){
        array_merge($result,$this->findInheritedRoles($role->parent_role));
      }
    }
    return $result;
  }

  /**
   * Funkce pro nalezení povolených zdrojů v závislosti na rolích
   * @param string[] $rolesArr
   * @return array
   */
  public function findResourcesByRoles($rolesArr){
    if (count($rolesArr)>0){
      foreach($rolesArr as &$role){
        $role="'".$role."'";
      }
      $rolesSql=implode(',',$rolesArr);
    }else{
      $rolesSql="'guest'";
    }
    $query=self::$pdo->prepare('SELECT * FROM resources WHERE `role` IN ('.$rolesSql.')');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_CLASS);
  }

  /**
   * Funkce pro ověření, jestli má uživatel v zadané roli právo přistupovat k danému zdroji
   * @param string $userRole
   * @param string $resource
   * @param string $action
   * @return bool
   */
  public function isAllowed($userRole, $resource, $action){
    $rolesArr=$this->findInheritedRoles($userRole);
    if (count($rolesArr)>0){
      foreach($rolesArr as &$role){
        $role="'".$role."'";
      }
      $rolesSql=implode(',',$rolesArr);
    }else{
      $rolesSql="'guest'";
    }
    $query=self::$pdo->prepare('SELECT role FROM resources WHERE `role` in ('.$rolesSql.') AND resource=:resource AND (`action`=\'\' OR `action`=:action);');
    $query->execute([':resource'=>$resource,':action'=>$action]);
    return ($query->fetchAll()>0);
  }

}