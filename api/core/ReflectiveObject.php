<?php

abstract class ReflectiveObject implements JsonSerializable {

  protected $class;

  private $reflectionClass;
  private $reflectionMethods;
  private $reflectionProperties;
  
  
  private function init() {
    if (isset($this->reflectionClass))
      return;
    $this->class                = $this->getClass();
    $this->reflectionClass      = new ReflectionClass(get_called_class());
    $this->reflectionMethods    = $this->reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED);
    $this->relfectionProperties = $this->reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
  } // end init() function
  
  public function JsonSerialize() {
    return $this->getProperties();
  } // end JsonSerialize() function
  
  
  public function __toString() {
    return json_encode($this, JSON_PRETTY_PRINT);
  } // end __toString() function
  
  
  public function getClass() {
    return get_called_class();
  } // end getClass() function
  
  
  public function getMethods() {
    $this->init();
    
    $result = array();
    
    foreach ($this->reflectionMethods as $m)
      $result[] = $m->name;
    
    return $result;
  } // end getMethods() function
  
  
  public function getMethodParameters($method) {
    $this->init();
    
    if (!$this->reflectionClass->hasMethod($method))
      return false;
      
    $result = array();
    $m = $this->reflectionClass->getMethod($method);
    
    foreach($m->getParameters() as $p) {
      $result[$p->getName()]['class']       = $p->getClass();
      
      try {
        $result[$p->getName()]['default']   = $p->getDefaultValue();
      } catch (ReflectionException $e) {
        $result[$p->getName()]['default']   = NULL;
      }
      
      $result[$p->getName()]['isArray']     = $p->isArray();
      $result[$p->getName()]['isOptional']  = $p->isOptional();
    }
    
    return $result;
  } // end getMehodParameters() function
  
  
  public function getProperty($property) {
    $this->init();
    
    if (!$this->reflectionClass->hasProperty($property))
      return false;
    
    return $this->$property;
  }
  
  
  public function getProperties() {
    $this->init();
    
    $result = array();  
    foreach ($this->relfectionProperties as $reflectedProperty) {
      if ($reflectedProperty->isPrivate())
        continue;
      $property = $reflectedProperty->getName();
      $result[$property] = $this->$property;
    }
    return $result;

  } // end getProperties() function
  
  
  public function setProperty($property, $value) {
    $this->init();
    
    if (!$this->reflectionClass->hasProperty($property))
      return false;
      
    $this->$property = $value;
    return true;      
  } // end setProperty() function


  public function setProperties(array $properties) {
    $this->init();
    
    foreach ($properties as $key => $value)
      $this->setProperty($key, $value);
    
  } // end setProperties() function
  
}
