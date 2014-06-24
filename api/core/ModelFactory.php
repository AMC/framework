<?php

class ModelFactory {
  
  protected $database;
  
  
  public function __construct($database) {
    $this->database = $database;
  } // end __construct() public function
  
  
  public function newModel($model_name, array $params = array()) {
    if (!class_exists($model_name))
      return false;  // throw exception
      
    $model = new $model_name();
    $model->setDatabase($this->database);
    $model->setProperties($params);
    return $model;
  } // end function
  
  
  public function find($model, array $predicates = array(), $limit = 10, $offset = 0, array $sort = array()) {
    $result = array();
    $json = $this->database->find($model, $predicates, $limit, $offset, $sort);

    foreach(json_decode($json) as $doc) {
      $model = new $doc->class();
      $model->setDatabase($this->database);
      $model->load(json_encode($doc), JSON_PRETTY_PRINT);
      $result[] = $model;
    } // end foreach
    
    return $result;     
  } // end function
  
  
  public function findById($model, $id) {
    
  } // end function
  
  
  public function findBySlug($model, $slug) {
    
  } // end function
  
  
  public function findFirst($model, $count) {
    
  } // end function
  
  
  public function findLast($model, $count) {
    
  } // end function
  
  
}
