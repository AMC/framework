<?php

include 'controller/controller.php';
include 'model/model.php';

if (isset($_SERVER['REQUEST_METHOD']))
  $method = strtolower($_SERVER['REQUEST_METHOD']);
else
  $method = 'get';

if (method_exists('Controller', $method))
  Controller::$method();
else
  die("die!");
  
  
die();
echo "<pre>";
print_r($_SERVER);

  if (isset($_GET['action']))
    $action = $_GET['action'];
  else
    $action = NULL;
    
  if (isset($_GET['property']))
    $property = $_GET['property'];
  else
    $property = NULL;  
    
  if (isset($_GET['value']))
    if ((string)(int) $_GET['value'] == $_GET['value'])
      $value = (int)$_GET['value'];
    else
      $value = $_GET['value'];
  else
    $value = NULL;


  $mongo = new MongoClient();

  $db = $mongo->test;

  $users = $db->users;
  
?>

<a href='index.php'>reset</a>
<br><br>
<form action='index.php' method='post'>
<input type='text' placeholder='init | reset | list | find' name='action' value='<?=$action?>'>
<br>
<input type='text' placeholder='property' name='property' value='<?=$property?>'>
<br>
<input type='text' placeholder='value' name='value' value='<?=$value?>'>
<br>
<input type='submit'>
</form>

<br><br>
<pre>
  
<?php

  if ($action == 'init') {
    for ($i = 0; $i < 100; $i++) 
      $response = $users->insert(array(
        'name'   => "user{$i}",
        'number' => $i,
        'slug'   => $i,
        
      ));
      print_r($response);
  }


  if ($action == 'reset') {
    $response = $users->drop();
    print_r($response);
  }


  if ($action == 'list') {
    $cursor = $users->find();
    
    $result = array();

    foreach ($cursor as $document) 
      $result[] = $document;

    echo json_encode($result, JSON_PRETTY_PRINT);
      
  }

  if ($action == 'find' && !is_null($property) && !is_null($property)) {
    $query = array("{$property}" => $value);
    $cursor = $users->find($query);
    $result = array();

    foreach ($cursor as $document) 
      $result[] = $document;

    echo json_encode($result, JSON_PRETTY_PRINT);
    
    
  }

?>


end