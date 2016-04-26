<?php

namespace Blog\Model\Entities;

/**
 * Class Article
 * @package Blog\Model\Entities
 * @property int $id
 * @property string $title
 * @property string $perex
 * @property string $content
 * @property int $category
 * @property string|null $categoryName
 * @property int $author
 * @property string|null $authorName
 * @property string $last_modified
 */
class Article{

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
      'title'=>@$this->title,
      'perex'=>@$this->perex,
      'content'=>@$this->content,
      'category'=>@$this->category,
      'author'=>@$this->author,
    ];
    if (!empty($this->id)){
      $result['id']=$this->id;
    }
    return $result;
  }

}