<?

/**
* 
*/
class Model
{
  protected $id;
  
  private $properties;
  private $reflectionClass;
  
  
  function __construct($params)
  {
    #TODO: set database strategy - mySQL, PostGreSQL, MongoDB
  }
  
  
  function create($params = NULL) 
  {
    $this->validate();
    
  }
  
  function read($params = NULL)
  {
    
  }
  
  function update($id) 
  {
    $this->validate();
    
  }
  
  function delete($id)
  {
    
  }
  
  
  // Reflection Methods
  function setReflectionClass() {
    $this->reflectionClass = new ReflectionClass(get_class($this));
  }
  
  function getProperties()
  {
    
  }
  
  function getProperty($property)
  {
    
  }
  
  function setProperty($property, $value)
  {
    
  }
  // end Reflection Methods
  
  
  function validate() 
  {
    
  }
  
}
