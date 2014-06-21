<?php

class Model extends ReflectiveObject {
  
  const IS_PRIVATE = 1;
  const IS_GROUP   = 2;
  const IS_PUBLIC  = 4;


  protected $use_default_controller = true;

  protected $_id          = NULL;
  protected $groups       = array();
  protected $created      = NULL;
  protected $updated      = NULL;
  protected $visibility   = Model::IS_PRIVATE;
  
  protected $data;
  
  private   $database;
  
  public function __construct() {
    
    $this->data = new Component();
    $this->data->setProperty("value", "pirates");
  } // end function
  
  
  public function setDatabase($database) {
    $this->database = $database;
  } // end function
  
  
  public function setId($id) {
    $this->_id = new MongoId($id);
  }
  

  public function isValid() {
    // Iterate through components and delegate validation
    foreach ($this->getProperties() as $key => $value)     
      if (is_a($value, 'Component')) 
        if (!$value->isValid())
          return false;

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
