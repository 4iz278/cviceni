<?php

namespace Blog\Model;
use Blog\Library\Singleton;
use \PDO;
use Blog\Model\Entities\Category;

/**
 * Class CategoriesModel - třída modelu pro práci s kategoriemi v DB
 * @package Blog\Model
 */
class CategoriesModel extends BaseModel{
  use Singleton;

  /**
   * Funkce pro nalezení všech článků (v případě zadání parametru $category jen v dané kategorii)
   * @return Category[]
   */
  public function findAll(){
    $query=self::$pdo->prepare('SELECT * FROM categories ORDER BY `order`;');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_CLASS,__NAMESPACE__.'\Entities\Category');
  }

  /**
   * Funkce pro nalezení jedné kategorie
   * @param int $id
   * @return Category
   */
  public function find($id){
    $query=self::$pdo->prepare('SELECT * FROM categories WHERE id=:id LIMIT 1;');
    $query->execute([':id'=>$id]);
    return $query->fetchObject(__NAMESPACE__.'\Entities\Category');
  }

  //TODO tady budou nějaké metody pro ukládání kategorií, nastavení jejich pořadí atd.


}