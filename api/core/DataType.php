<?php

class DataType {
  protected $type;
  private $allowedTypes = array(
    "string",
    "text",
    "integer",
    "decimal",
    "boolean",
  );
  
  public function __construct($type) {
    if (!in_array(strtolower($type), $this->allowedTypes)) 
      throw new Exception('Invalid data type');
        
    $this->type = strtolower($type);
  }
  
  public function __toString() {
    $this->type;
  }
  
  
}