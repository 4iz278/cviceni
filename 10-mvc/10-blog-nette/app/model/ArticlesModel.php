<?php

namespace Blog\Model;
use \PDO;
use Blog\Model\Entities\Article;

/**
 * Class ArticlesModel - třída modelu pro práci s články v DB
 * @package Blog\Model
 */
class ArticlesModel{
  /** @var PDO $pdo */
  private $pdo;

  /**
   * Funkce pro nalezení všech článků (v případě zadání parametru $category jen v dané kategorii)
   * @param null|int $category
   * @return Article[]
   */
  public function findAll($category=null){
    if ($category>0){
      $query=$this->pdo->prepare('SELECT * FROM articles WHERE category=:category;');
      $query->execute([':category'=>$category]);
    }else{
      $query=$this->pdo->prepare('SELECT * FROM articles');
      $query->execute();
    }
    return $query->fetchAll(PDO::FETCH_CLASS,__NAMESPACE__.'\Entities\Article');
  }

  /**
   * Funkce pro nalezení jednoho článku
   * @param int $id
   * @param bool $includeTextAliases=false - pokud je true, dojde k načtení názvu kategorie a jména autora
   * @return Article
   */
  public function find($id,$includeTextAliases=false){
    if ($includeTextAliases){
      $sql='SELECT articles.*,users.name AS authorName,categories.name AS categoryName FROM articles LEFT JOIN users ON articles.author=users.id LEFT JOIN categories ON articles.category=categories.id WHERE articles.id=:id LIMIT 1;';
    }else{
      $sql='SELECT * FROM articles WHERE id=:id LIMIT 1;';
    }
    $query=$this->pdo->prepare($sql);
    $query->execute([':id'=>$id]);
    return $query->fetchObject(__NAMESPACE__.'\Entities\Article');
  }

  /**
   * Funkce pro smazání jednoho článku
   * @param Article|int $id
   * @return bool
   */
  public function delete($id){
    if ($id instanceof Article){
      $id=$id->id;
    }
    $query=$this->pdo->prepare('DELETE FROM articles WHERE id=:id LIMIT 1;');
    return $query->execute([':id'=>$id]);
  }

  /**
   * @param Article $article
   * @return bool
   */
  public function save(Article $article){
    $dataArr=$article->getDataArr();
    $paramsArr=[];
    if (@$article->id>0){
      //updatujeme existující článek
      $sql='';
      foreach($dataArr as $key=>$value){
        if ($key=='id'){continue;}
        $sql.=($sql!=''?',':'').' '.$key.'=:'.$key;
        $paramsArr[':'.$key]=$value;
      }
      $sql='UPDATE articles SET '.$sql.' WHERE id=:id LIMIT 1;';
      $paramsArr[':id']=$article->id;
      $query=$this->pdo->prepare($sql);
      $result=$query->execute($paramsArr);
    }else{
      //insert nového článku
      $sql='INSERT INTO articles (';
      $sql.=implode(',',array_keys($dataArr));
      $sql.=')VALUES(';
      foreach($dataArr as $key=>$value){
        $paramsArr[':'.$key]=$value;
      }
      $sql.=implode(',',array_keys($paramsArr));
      $sql.=')';
      $query=$this->pdo->prepare($sql);
      $result=$query->execute($paramsArr);
      $article->id=$this->pdo->lastInsertId('articles');
    }
    return $result;
  }


  /**
   * ArticlesModel constructor
   * @param PDO $pdo
   */
  public function __construct(\PDO $pdo){
    $this->pdo=$pdo;
  }

}