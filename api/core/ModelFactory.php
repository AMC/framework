<?php

class ModelFactory {
  
  protected $database;
  
  
  public function __construct($database) {
    $this->database = $database;
  } // end __construct() public function
  
  
  public function newModel($model, array $params) {
    // TODO: check if model exists
    $model = new $model();
    $model->setDatabase($this->database);
    return $model;
  } // end function
  
  
  public function find($model, $predicates = array(), $limit = 10, $offset = 0, $sort = array()) {
    $result = array();
    $json = $this->database->find($model, $predicates, $limit, $offset, $sort);
    //print_r($json);
    foreach(json_decode($json) as $doc) {
      $model = new $doc->class();
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
