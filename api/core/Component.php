<?php

class Component extends ReflectiveObject {
  
  protected $value      = NULL;
  protected $type       = 'String';
  protected $required   = false;
  protected $validation = '/^(\w|\s)+$/';
  

  public function __construct() {
    $this->value = NULL;

  } // end __construct() function

  // getters and setters through reflective object  
  
  public function isValid() {
    if (is_null($this->validation))
      return false;
    
    if ($this->required && is_null($this->value))
      return false;
    
    if (!preg_match($this->validation, $this->value))
      return false;
      
    return true;
  } // end function
  

}