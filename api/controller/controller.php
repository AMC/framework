<?php

/**
* 
*/
class Controller
{
  
  static function options()
  {
    # return information about available commands
    # TODO: use PHPDoc style syntax for more information
    echo json_encode(self::document(), JSON_PRETTY_PRINT);
    die();
  }
  
  static function get() 
  {
    #getAll, getFirst, getLast
    #retrieve params from $_GET
    #$result = $database->find($collection, "array", $params);
    echo json_encode(Model::getAll());
    die();
  }
  
  static function post()
  {
    # retrieve params from $_POST
    # non-idempotent
    # create
    # partial update
    echo "Controller::post<br>";
  }
  
  static function put(array $p, array $q=NULL) 
  {
    # retrieve params from $_PUT
    # idempotent
    # full replacement update
    # create if id is known
    echo "Controller::put<br>";
  }
  
  static function delete() 
  {
    #retrieve params from ?
    echo "Controller::delete<br>";
    parse_str(file_get_contents('php://input'), $params);
    print_r($params);
    $result = $database->delete($collection, $params);
  }
  
  
  private static function document() {
    # TODO: only return methods user has permission to use
    $result = array();
    
    $reflectionClass = new ReflectionClass(get_called_class());
    $reflectionMethods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
    
    $i = 0;
    foreach ($reflectionMethods as $reflectionMethod) {
      $result[$i] = array('name' => $reflectionMethod->getName());
      $params = $reflectionMethod->getParameters();

      foreach ($params as $p) {
        $result[$i]['params'][] = array(
          'name' => $p->getName(), 
          'required' => $p->isOptional()
        );
      }
     
      $i++;
    }
    
    return $result;
  }
  
}
