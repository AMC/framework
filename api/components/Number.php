<?php

class Number extends Component {
  
  public function __construct() {
    $this->value      = NULL;
    $this->type       = new DataType("Integer");
    $this->required   = false;
    $this->validation = '^\d+$';

  } // end __construct() function
}