<?php

abstract class Model extends ReflectiveObject {
  
  // permission levels
  const IS_PRIVATE = 1;
  const IS_GROUP   = 2;
  const IS_PUBLIC  = 4;


  // if true, does not require a custom controller
  protected $use_default_controller = false;


  protected $_id          = NULL;
  protected $groups       = array();
  protected $permission   = Model::IS_PRIVATE;  
    
  private   $database;
  
  
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
      throw new Exception('Cannot save invalid model: ' . $this->getClass());
    
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
