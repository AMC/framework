<?php

class TextArea extends Component {
  
  public function __construct() {
    $this->value      = NULL;
    $this->type       = new DataType("String");
    $this->required   = false;
    $this->validation = '^.*$';

  } // end __construct() function
  
  public function clean() {
    // do nothing
    // WARNING: POTENTIALLY UNSAFE COMPONENT TYPE
    // subject to cross-site scripting, embedded code, etc.
  }
}