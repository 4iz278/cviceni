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
  public function findAll():array {
    $query=self::$pdo->prepare('SELECT * FROM mvc_categories ORDER BY `order`;');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_CLASS,'\Blog\Model\Entities\Category');
  }

  /**
   * Funkce pro nalezení jedné kategorie
   */
  public function find(int $id):?Category {
    $query=self::$pdo->prepare('SELECT * FROM mvc_categories WHERE id=:id LIMIT 1;');
    $query->execute([':id'=>$id]);
    return $query->fetchObject('\Blog\Model\Entities\Category');
  }

  //TODO tady budou nějaké metody pro ukládání kategorií, nastavení jejich pořadí atd.


}