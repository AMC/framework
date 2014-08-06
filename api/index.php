<?php

  //$controller_name = 'Blog';
  $controller_name = $_SERVER['CONTROLLER'];
  $method = strtolower($_SERVER['REQUEST_METHOD']);



  require_once 'config/includes.php';
  // TODO: authenticate request

  $database_driver = new MongoDriver($database_config);
  $database = new Database($database_driver);
  
  $model_factory = new ModelFactory($database);
  $controller_factory = new ControllerFactory($model_factory);

  $controller = $controller_factory->get($controller_name);
  
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