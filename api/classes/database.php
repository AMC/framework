<?php

/**
* 
*/
class Database
{
  
  protected $client;
  protected $database;

  
  function __construct($database)
  {
    $this->client = new MongoClient();
    $this->database = $this->client->$database;
  }
  
  function save($collection, $object) 
  {
    if (method_exists($object, "getId") && $object->getId() != NULL)
      $this->database->$collection->update(array(
        "_id" => $object->getId(),
      ), $object);
    else
      $this->database->$collection->insert($object);
  }
  
  function delete($collection, $params)
  {
    $params = $this->filterParams($params);
    
    if ($params == NULL || empty($params))
      return;
      
    $this->database->$collection->remove($params);
  }
  
  function drop($collection) {
    $this->database->$collection->drop();
  }
  
  function size($collection)
  {
    return $this->database->$collection->count();
  }
  
  function status() 
  {
    echo "<pre>";
    echo "client: <br>";
    print_r($this->client);
    echo "database: <br>";
    print_r($this->database);
    echo "</pre>";
  }
  
  function getResults($cursor, $class)
  {
     $results = array();

     foreach ($cursor as $document)
       if ($class = "array")
         $results[] = $document;
       else
         $results[] = new $class($document);

     
     
     return $results;
  }
  
  function filterParams($params)
  {
    if ($params != NULL) 
      foreach ($params as $key => $value)
        if ($value == "")
          unset($params[$key]);
    
    return $params;
  }
    

  // TODO: in model, generate collection based on class name
  // TODO: limit and offset
  function find($collection, $class, $params = NULL, $limit = NULL, $skip = NULL)
  {
    $params = $this->filterParams($params);
    
    if ($params == NULL || empty($params))
      $cursor = $this->database->$collection->find()->limit($limit)->skip($skip);
    else
      $cursor = $this->database->$collection->find($params)->limit($limit)->skip($skip);
      
    return $this->getResults($cursor, $class);
  }
  
  function findFirst($collection, $class, $params = NULL, $limit = 1)
  {
    return $this->find($collection, $class, $params, $limit, 0);  
  }
  
  function findLast($collection, $class, $params = NULL, $limit = 1)
  {
    return $this->find($collection, $class, $params, $limit, $this->size($collection) - $count);
  }
  
  function findAll($collection, $class) 
  {
    return $this->find($collection, $class);
  }
  
}
