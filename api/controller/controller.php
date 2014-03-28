<?php

/**
* 
*/
class Controller
{
  
  static function options($params)
  {
    # return information about available commands
    # TODO: use PHPDoc style syntax for more information
    # TODO: check incoming request for:
    #  list of all controllers
    #  methods of a controller
    #  model fields (for generating new/edit form)
    #  permissions
    #  all
    echo json_encode(self::document(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    die();
  }
  
  static function get($params) 
  {
    #getAll, getFirst, getLast
    #retrieve params from $_GET
    #$result = $database->find($collection, "array", $params);
    echo json_encode(Model::getAll(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    die();
  }
  
  static function post($params)
  {
    # retrieve params from $_POST
    # non-idempotent
    # create
    # partial update
    echo "Controller::post<br>";
  }
  
  static function put($params) 
  {
    # retrieve params from $_PUT
    # idempotent
    # full replacement update
    # create if id is known
    echo "Controller::put<br>";
  }
  
  static function delete($params) 
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
