<?php

abstract class Model extends ReflectiveObject {
  
  // permission levels
  // private, group, public

  protected $_id          = NULL;
  protected $groups       = array();
  protected $permission   = 'private';  
    
  private   $database;
  
  
  // return true or false
  // if true, does not require a custom controller
  abstract public function useDefaultController();
  
  
  public function setDatabase($database) {
    $this->database = $database;
  } // end function
  
  
  public function setId($id) {
    $this->_id = new MongoId($id);
  } // end function
  

  public function isValid() {
    // Iterate through components and delegate validation
    foreach ($this->getProperties() as $key => $value)     
      if (is_a($value, 'Component')) {
        $value->clean();
        if (!$value->isValid())
          return false;
      } // end if
    return true;
  } // end function
  
    
  public function save() {
    if (!$this->isValid())
      return false;
    
    $this->_id = $this->database->save($this->getClass(), json_encode($this, JSON_PRETTY_PRINT));
    
    return true;
  } // end function
  
  
  public function load($json) {
    foreach (json_decode($json) as $key => $value)
      if (property_exists($this, $key))
        if (is_object($value) && isset($value->class)) {
          // TODO: verify object is a component
          $this->$key = new $value->class();
          $this->$key->setProperties((array)$value);
        } else { 
          $this->$key = $value;
        } // end if-else
  } // end function
  
  
  public function delete() {
    $predicates = array("_id" => $this->_id);
    $this->database->delete($this->getClass(), $predicates);
  } // end function
  
 
} // end class
