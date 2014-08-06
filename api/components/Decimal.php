<?php

class Decimal extends Component {
  
  public function __construct() {
    $this->value      = NULL;
    $this->type       = new DataType("Decimal");
    $this->required   = false;
    $this->validation = '^\d*\.\d*$';

  } // end __construct() function
}