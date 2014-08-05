<?php
  $controller_name = 'Blog';
  $method = strtolower($_SERVER['REQUEST_METHOD']);
  //$method = 'GET';
  

  require_once 'config/includes.php';
  // TODO: authenticate request

  $database_driver = new MongoDriver($database_config);
  $database = new Database($database_driver);
  
  $model_factory = new ModelFactory($database);
  $controller_factory = new ControllerFactory($model_factory);
  
  // TODO: check authorization
  if ($controller = $controller_factory->get($controller_name)) {
    $result = $controller->$method();
    if ($result)
      Response::success($result);
    else
      Response::fail();
  } else {
    Response::fail();
  }




