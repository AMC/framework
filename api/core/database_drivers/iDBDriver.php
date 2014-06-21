<?php

interface iDBDriver {
    
  public function __construct(array $database_config);
  
  public function save($table, $json);
  public function delete($model, array $predicates = NULL);
  public function find($table, array $predicates = NULL, $limit = 10, $offset = NULL, $sort = NULL);
  
}