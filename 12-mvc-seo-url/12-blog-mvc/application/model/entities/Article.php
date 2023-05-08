<?php

namespace Blog\Model\Entities;

/**
 * Class Article
 * @package Blog\Model\Entities
 */
class Article{
  public int $id;
  public string $title;
  public string $perex;
  public string $content;
  public int $category;
  public ?string $categoryName;
  public int $author;
  public ?string $authorName;
  public string $last_modified;

  /**
   * Funkce vracející celý obsah článku
   * @return string
   */
  public function getFullContent(){
    return $this->perex.$this->content;
  }

  /**
   * Funkce vracející pole s daty pro ukládání v DB
   * @return array
   */
  public function getDataArr(){
    $result=[
      'title'=>$this->title ?? '',
      'perex'=>$this->perex ?? '',
      'content'=>$this->content ?? '',
      'category'=>$this->category ?? '',
      'author'=>$this->author ?? '',
    ];
    if (!empty($this->id)){
      $result['id']=$this->id;
    }
    return $result;
  }

}