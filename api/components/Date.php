<?php

class Date extends Component {
  
  public function __construct() {
    $this->value      = NULL;
    $this->type       = new DataType("String");
    $this->required   = false;
    $this->validation = '^\d{4}-\d{2}-\d{2}$';   // yyyy-mm-dd

  } // end __construct() function
  
  
  public function clean() {
    $this->value = str_replace(array(
      '-', // dash
      '/', // slash
      '.', // dot
      ' ', // space
    ), '-', $this->value);
    
    parent::clean();
  }
  
}