<?php

/**
* 
*/
class Request implements JsonSerializable 
{
    private $path;
    private $path_array;

    private $base;
    private $method;

    private $class;
    private $slug;
    
    private $controller;

    private $params;



    public function __construct() 
    { 
      $this->setBase();
      $this->setPath();
      
      $this->setMethod();
      
      $this->setClass();
      $this->setSlug();
      
      $this->setController();
      
      $this->setParams();
    }


    public function getBase() 
    {
      return $this->base;
    }

    public function getClass() 
    {
      return $this->class;
    }
    
    public function getSlug() 
    {
      return $this->slug;
    }
    
    public function getController() 
    {
      return $this->controller;
    }
    
    public function getMethod()
    {
      return $this->method;
    }
    
    public function getParams() 
    {
      if (!empty($this->params))
        return $this->params;
      return array();
    }

    public function getParamsString() 
    {
      $result = "";
      foreach ($this->params as $key => $value)
        $result = "{$key} : {$value}";
      return $result;
    }


    private function setBase() 
    {
      if (isset($_SERVER['SCRIPT_NAME']))
        $this->base = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
      else
        $this->base = '';
    }
    
    private function setPath() 
    { 
      if (isset($_SERVER['PATH_INFO']))
        $this->path = $_SERVER['PATH_INFO'];
      else {
        $this->path = str_replace($this->base, "", $_SERVER['REQUEST_URI']);
      }
        

      $this->path_array = explode('/', $this->path);
    }

    private function setMethod() 
    {
      if (isset($_SERVER['REQUEST_METHOD']))
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
      else
        $this->method = 'get';
    }

    private function setClass() 
    {
      if (isset($this->path_array[1])) 
        $this->class = strtolower($this->path_array[1]);
      else 
        $this->class = NULL;
    }
    
    private function setSlug() 
    {
      if (isset($this->path_array[2])) 
        $this->slug = strtolower($this->path_array[2]);
      else 
        $this->slug = '';
    }

    private function setController() 
    {
      if (is_null($this->class))
        $this->setClass();

      $this->controller = $this->class . "Controller";
    }
    
    private function setParams() 
    {
      if ($this->method == 'get' && isset($_SERVER['QUERY_STRING']))
        parse_str($_SERVER['QUERY_STRING'], $this->params);
      else
        parse_str(file_get_contents("php://input"), $this->params);
    }
    
    
    public function execute() {
      if (!method_exists($this->controller, $this->method))
        die("TODO: 404 error");

      header('Content-Type: application/json');
      $c = $this->controller;
      $m = $this->method;
      $c::$this->m($params);
    }
    

    public function __toString() 
    {
      return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function jsonSerialize() 
    {
      return (object) get_object_vars($this);
    }
}
