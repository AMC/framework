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
  }
  
  static function get() 
  {
    #getAll, getFirst, getLast
    #retrieve params from $_GET
    echo "get";
  }
  
  static function post()
  {
    # retrieve params from $_POST
    # non-idempotent
    # create
    # partial update
    echo "post";
  }
  
  static function put(array $p, array $q=NULL) 
  {
    # retrieve params from $_PUT
    # idempotent
    # full replacement update
    # create if id is known
    echo "put";
  }
  
  static function delete() 
  {
    #retrieve params from ?
    echo "delete";
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
