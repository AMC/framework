<?php

class Database {
  
  protected $driver;
  
  public function __construct($driver) {
    $this->driver = $driver;
  } // end function
  
  
  public function save($model, $json) {
    return $this->driver->save($model, $json);
  } // end function
  
  
  public function delete($model, array $predicates) {
    $this->driver->delete($model, $predicates);
  } // end function
  
  
  public function find($table, array $predicates = NULL, $limit = 10, $offset = NULL, $sort = NULL) {
    return $this->driver->find($table, $predicates, $limit, $offset, $sort);
  } // end function


}
