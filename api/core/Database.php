<?php

class Database {
  
  protected $driver;
  
  public function __construct($driver) {
    $this->driver = $driver;
  } // end __construct() function
  
  
  public function save($table, $json) {
    return $this->driver->save($table, $json);
  }
  
  
  public function delete($table, array $predicates) {
    $this->driver->delete($table, $predicates);
  }
  
  
  public function find($table, array $predicates = NULL, $limit = 10, $offset = NULL, $sort = NULL) {
    $this->driver->find($table, $predicates, $limit, $offset, $sort);
  }


}
