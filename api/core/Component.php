<?php

class Component extends ReflectiveObject {
  
  protected $use_default_controller = true;
  protected $type                   = 'String';
  protected $required               = false;
  protected $validation             = '/^(\w|\s)+$/';
  
  protected $value;
  protected $class;
  
  
  // TODO: parameters as associative array
  public function __construct($value) {
    $this->value                  = $value;
  } // end __construct() function
  
  
  public function setValue($value) {
    $this->value = $value;
  } // end function
  
  
  public function setType($type) {
    $this->type = $type;
  } // end function
  
  
  public function setRequired(boolean $required) {
    $this->required = $required;
  } // end function
  
  
  public function setValidation($regex) {
    $this->validation = $regex;
  } // end function
  
  
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