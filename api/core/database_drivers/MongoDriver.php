<?php

class MongoDriver implements iDBDriver {
  
  private $database;
  private $connection;
  

  public function __construct(array $database_config) {
    $server   = "";
    $options  = array();

    if (!empty($database_config['host']))
      $server .= $database_config['host'];
      
    if (!empty($database_config['port']))
      $server .= ":" . $database_config['host'];
    
    
    if (!empty($database_config['username']))
      $options['username'] = $database_config['username'];
      
    if (!empty($database_config['password']))
      $options['password'] = $database_config['password'];
    
    $this->connection = new MongoClient("", $options);
    $this->database = $this->connection->$database_config['database'];
  } // end __construct() function
  
  
  public function save($table, $json) {
    // TODO: escape data: https://www.idontplaydarts.com/2010/07/mongodb-is-vulnerable-to-sql-injection-in-php-at-least/
    $obj = json_decode($json);
    if (is_null($obj->_id)) {
      $obj->_id = new MongoId();
      $this->database->$table->insert($obj);
    } else {
      $this->database->$table->save($obj);
    } // end if-else
    
    return $obj->_id;
  } // end function
  
  
  public function delete($table, array $predicates = array()) {
    $this->database->$table->remove($predicates);
  } // end function
  
  
  public function find($table, array $predicates = array(), $limit = 10, $skip = 0, $sort = array('_id' => 1)) {
    $result = array();
    $cursor = $this->database->$table->find($predicates)->sort($sort)->skip($skip)->limit($limit);
    foreach ($cursor as $c)
      $result[] = new $c['class']($c);
    return $result;
  } // end function
  
} // end class