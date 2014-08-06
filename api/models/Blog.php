<?php

class Blog extends Model {
  
  protected $author;
  protected $title;
  protected $date;
  protected $post;
  protected $comments;


  public function useDefaultController() {
    return true;
  } // end function
    
  
  public function __construct() {
    $this->permission = 'private';    
    
    $this->author = new String();
    $this->author->setProperty('required', true);
        
    $this->title = new String();
    $this->title->setProperty('required', true);

    $this->date = new Date();
    $this->date->setProperty('required', true);
 
    $this->post = new TextArea();
    $this->post->setProperty('required', true);

    $this->comments = array(); 
  } // end function

  
  public function addComment(Comment $comment) {
    if ($comment->isValid())
      $this->comments[] = $comment;
    else
      throw new Exception('Cannot add invalid comment: ' . $comment);
  } // end function
  

}