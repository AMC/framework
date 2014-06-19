<?php

class ModelFactory {
  
  protected $database;
  
  
  public function __construct($database) {
    $this->database = $database;
  } // end __construct() public function
  
  
  public function newModel($model, array $params) {
    // TODO: check if model exists
    $model = new $model($params);
    $model->setDatabase($this->database);
    return $model;
  } // end function
  
  
  public function find($table, array $predicates = NULL, $limit = 10, $offset = NULL, $sort = NULL) {
    
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
