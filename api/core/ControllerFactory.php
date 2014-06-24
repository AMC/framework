<?php

class ControllerFactory {
  
  protected $model_factory;
  
  public function __construct(ModelFactory $model_factory) {
    $this->model_factory = $model_factory;
  } // end function
  
  
  public function get($controller) {
    $model_name = $controller;
    $controller_name = $controller . "Controller";
    
    if (class_exists($controller_name))
      return new $controller_name($this->model_factory);
    
    if (class_exists($model_name)) {
      $model = $this->model_factory->newModel($model_name);
      if ($model->useDefaultController()) {
        $controller = new Controller($this->model_factory);
        $controller->setModel($model_name);
        return $controller;
      }
    }
      
    return false;
  } // end function
  
} // end class