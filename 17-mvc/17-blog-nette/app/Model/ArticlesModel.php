<?php

namespace Blog\Model;
use \PDO;
use Blog\Model\Entities\Article;

/**
 * Class ArticlesModel - třída modelu pro práci s články v DB
 * @package Blog\Model
 */
class ArticlesModel{
  private PDO $pdo;

  /**
   * Funkce pro nalezení všech článků (v případě zadání parametru $category jen v dané kategorii)
   * @param null|int $category
   * @return Article[]
   */
  public function findAll(?int $category=null):array{
    if ($category>0){
      $query=$this->pdo->prepare('SELECT * FROM mvc_articles WHERE category=:category;');
      $query->execute([':category'=>$category]);
    }else{
      $query=$this->pdo->prepare('SELECT * FROM mvc_articles');
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
  public function find(int $id,bool $includeTextAliases=false):Article{
    if ($includeTextAliases){
      $sql='SELECT mvc_articles.*,mvc_users.name AS authorName,mvc_categories.name AS categoryName FROM mvc_articles LEFT JOIN mvc_users ON mvc_articles.author=mvc_users.id LEFT JOIN mvc_categories ON mvc_articles.category=mvc_categories.id WHERE mvc_articles.id=:id LIMIT 1;';
    }else{
      $sql='SELECT * FROM mvc_articles WHERE id=:id LIMIT 1;';
    }
    $query=$this->pdo->prepare($sql);
    $query->execute([':id'=>$id]);
    return $query->fetchObject('\Blog\Model\Entities\Article');
  }

  /**
   * Funkce pro smazání jednoho článku
   * @param Article|int $id
   * @return bool
   */
  public function delete(Article|int $id):bool{
    if ($id instanceof Article){
      $id=$id->id;
    }
    $query=$this->pdo->prepare('DELETE FROM mvc_articles WHERE id=:id LIMIT 1;');
    return $query->execute([':id'=>$id]);
  }

  /**
   * @param Article $article
   * @return bool
   */
  public function save(Article $article):bool{
    $dataArr=$article->getDataArr();
    $paramsArr=[];
    if (!empty($article->id)){
      //updatujeme existující článek
      $sql='';
      foreach($dataArr as $key=>$value){
        if ($key=='id'){continue;}
        $sql.=($sql!=''?',':'').' '.$key.'=:'.$key;
        $paramsArr[':'.$key]=$value;
      }
      $sql='UPDATE mvc_articles SET '.$sql.' WHERE id=:id LIMIT 1;';
      $paramsArr[':id']=$article->id;
      $query=$this->pdo->prepare($sql);
      $result=$query->execute($paramsArr);
    }else{
      //insert nového článku
      $sql='INSERT INTO mvc_articles (';
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