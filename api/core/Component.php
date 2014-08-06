<?php

abstract class Component extends ReflectiveObject {
  
  protected $value;
  protected $required;
  protected $validation;
  

  public function __construct() {
    $this->value      = NULL;
    $this->required   = false;
    $this->validation = '^.*$';
  } // end function


  // getters and setters through reflective object  

  
  public function isValid() {
    if (is_null($this->validation))
      return false;
    
    if ($this->required && is_null($this->value))
      return false;
    
    if (!preg_match('/' . $this->validation . '/', $this->value))
      return false;
      
    return true;
  } // end function
  
  
  public function clean() {
    // clean up data any extra characters
    $this->value = htmlentities($this->value);
  } // end function
  

} // end class