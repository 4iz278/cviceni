<?php

/**
 * Class ArticlesModel - třída modelu pro práci s články v DB
 */
class ArticlesModel{
  /** @var PDO $pdo */
  private $pdo;

  /**
   * Funkce pro nalezení všech článků (v případě zadání parametru $category jen v dané kategorii)
   * @param null|int $category
   * @return array
   */
  public function findAll(?int $category=null):array {
    if ($category>0){
      $query=$this->pdo->prepare('SELECT * FROM articles WHERE category=:category;');
      $query->execute([':category'=>$category]);
    }else{
      $query=$this->pdo->prepare('SELECT * FROM articles');
      $query->execute();
    }
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Funkce pro nalezení jednoho článku
   * @param int $id
   * @return array
   */
  public function find(?int $id):array{
    $query=$this->pdo->prepare('SELECT * FROM articles WHERE id=:id LIMIT 1;');
    $query->execute([':id'=>$id]);
    return $query->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Funkce pro smazání jednoho článku
   * @param int $id
   * @return bool
   */
  public function delete(int $id):bool {
    $query=$this->pdo->prepare('DELETE FROM articles WHERE id=:id LIMIT 1;');
    return $query->execute([':id'=>$id]);
  }

  /**
   * ArticlesModel constructor
   * @param PDO $pdo
   */
  public function __construct(PDO $pdo){
    $this->pdo=$pdo;
  }

}