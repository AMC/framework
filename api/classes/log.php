<?php

/**
* 
*/

/* 

notes:
  due to mounting drive to server cannot allows writes unless folder and file is 777
    logs folder's permissions are 777
    must change log file's permission after initial creation

*/
class Log
{
  private $file;
  
  function __construct($filename) {
    $this->file = fopen($filename, "a");
  }
  
  function __destruct() 
  {
    fclose($this->file);
  }

  function toFile($message)
  {
    fwrite($this->file, $message . "\n");
  }
  
  function close() {
    $this->__destruct();
  }


}