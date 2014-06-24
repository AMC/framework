<?php

class Response {
  
  static public function success($data) {
    $result = array();
    $result['status'] = 'success';
    $result['status_code'] = '200';
    $result['data'] = $data;

    echo json_encode($result, JSON_PRETTY_PRINT);
  } // end function
  
  
  static public function fail() {
    // 400
    echo "400";
  } // end function
  
  
  static public function unauthorized($result) {
    // 401
    echo "401";
  }
  
} // end class
