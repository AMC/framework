<?php

class Model extends ReflectiveObject {
  
  const IS_PRIVATE = 1;
  const IS_GROUP   = 2;
  const IS_PUBLIC  = 4;


  protected $_id;
  protected $groups;
  protected $created;
  protected $updated;
  protected $visibility;
  
  protected $data;
  
  private   $database;
  
  public function __construct($params) {
    foreach ($params as $key => $value) 
      if (property_exists($this, $key))
          $this->$key = $value;
    
    // TODO: create appropiate containers
    /*
    print_r($params['_id']);
    if ($params['_id'])
      $this->id = $params['_id'];
    else 
      $this->_id        = NULL;
    $this->groups     = array();
    $this->created    = NULL;
    $this->updated    = NULL;
    $this->visibility = Model::IS_PRIVATE;
    $this->data       = new Component("hello there");
    */
  } // end function
  
  
  public function setDatabase($database) {
    $this->database = $database;
  } // end function
  

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
    
    // TODO: update object to match database
    $this->_id = $this->database->save($this->getClass(), json_encode($this, JSON_PRETTY_PRINT));

    return true;
  } // end save() function
  
  
  public function delete() {
    $predicates = array("_id" => $this->_id);
    $this->database->delete($this->getClass(), $predicates);
  } // end function
  
  
  
  
  
  
} // end class
