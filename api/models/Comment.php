<?php

class Comment extends Model {
  
  protected $author;
  protected $date;
  protected $comment;
  
  
  public function useDefaultController() {
    return false;
  } // end function
  
  
  public function __construct() {
    $this->author = new String();
    $this->author->setProperty('required', true);
    
    $this->date = new Date();
    $this->date->setProperty('required', true);
 
    $this->comment = new Text();
    $this->comment->setProperty('required', true);
  } // end function
  
}