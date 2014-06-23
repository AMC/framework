<?php

class String extends Component {
  
  public function __construct() {
    $this->value      = NULL;
    $this->type       = new DataType("String");
    $this->required   = false;
    $this->validation = '/^.{0,255}$/';

  } // end __construct() function
}