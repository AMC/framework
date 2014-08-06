<?php

class Controller {
  
  private $model_factory;
  private $model_name;
  
  
  public function __construct(ModelFactory $model_factory) {
    $this->model_factory = $model_factory;
  } // end function
  
  
  // for default controller only
  public function setModel($model_name) {
    $this->model_name = $model_name;
  } // end function
  
  
  public function get() {
    // TODO: get parameters for id
    // TODO: only show information appropiate to user

    return $this->model_factory->find($this->model_name);
  } // end function
  
  
  // non-idempotent
  public function post() {
    // mod_rewrite strips post content, must use query string
    // parse_str(file_get_contents('php://input'), $params);
    $params = $_GET;

    
    $model = $this->model_factory->newModel($this->model_name, $params);

    if ($model->save())
      return $model;
    return false;
    
  } // end function
  
  
  public function put() {
    // mod_rewrite strips post content, must use query string
    // parse_str(file_get_contents('php://input'), $params);
    $params = $_GET;

    if (!array_key_exists('_id', $params))
      return false;
      
    $model = $this->model_factory->newModel($this->model_name, $params);
    if ($model->save())
      return $model;
    return false;
    
  } // end function
  
  
  public function delete() {
    $params = $_GET;

    if (!array_key_exists('_id', $params))
      return false;
      
    $model = $this->model_factory->newModel($this->model_name, $params);
    $model->delete();
    
    return true;
    
  } // end function
  
  
  // returns an empty model which includes data types and validations
  public function options() {
    $model = $this->model_factory->newModel($this->model_name); 
    return $model;
  } // end function
  
} // end class