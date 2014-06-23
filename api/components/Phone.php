<?php

class Phone extends Component {
  
  public function __construct() {
    $this->value      = NULL;
    $this->type       = new DataType("String");
    $this->required   = false;
    $this->validation = '/^\d{3}-\d{3}-\d{4}$/';

  } // end __construct() function
  
  public function clean() {
    $this->value = str_replace(array(
      '-', // dash
      '/', // slash
      '.', // dot
      ' ', // space
    ), '-', $this->value);
    
    $this->value = str_replace(array(
      '(', // left paren
      ')', // right paren
    ), '', $this->value);
    
    parent::clean();
  }
}