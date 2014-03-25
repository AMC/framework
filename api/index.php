<?php

include 'classes/log.php';
include 'classes/database.php';

include 'controller/controller.php';
include 'model/model.php';

$log = new Log("logs/log.txt");
$database = new Database("test");



if (isset($_SERVER['REQUEST_METHOD']))
  $method = strtolower($_SERVER['REQUEST_METHOD']);
else
  $method = 'get';

if (method_exists('Controller', $method))
  Controller::$method();
else
  die("die!");



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



#$mongo = new MongoClient();
#$db = $mongo->test;

#$users = $db->users;
$collection = "users";


echo "action: " . $action . "<br>"; 
?>

<style>
  input {
    width: 50%;
  }
</style>

<hr>

<?= $database->size($collection); ?> Entries
<hr>  

<a href='index.php'>reset</a>
<br><br>
<form action='index.php' method='get'>
<input type='text' placeholder='init | reset | list | find | first | last | delete' name='action' value='<?=$action?>'>
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
      $database->save("users", array(
        'name'   => "user{$i}",
        'number' => $i,
        'slug'   => $i,
      ));
  }


  if ($action == 'reset') {
    $database->drop($collection);
  }


  if ($action == 'list') {
    $result = $database->findAll($collection, "array");
    echo json_encode($result, JSON_PRETTY_PRINT);
  }

  if ($action == 'find' && !is_null($property) && !is_null($property)) {
    $params = array("{$property}" => $value);
    $result = $database->find($collection, "array", $params);
    echo json_encode($result, JSON_PRETTY_PRINT);
  }
  
  if ($action == 'delete' && !is_null($property) && !is_null($property)) {
    $params = array("{$property}" => $value);
    $result = $database->delete($collection, $params);
    echo json_encode($result, JSON_PRETTY_PRINT);
  }
  
  if ($action == 'first'){
    $result = $database->findFirst($collection, "array");
    echo json_encode($result, JSON_PRETTY_PRINT);
  }
  
  if ($action == 'last'){
    $result = $database->findLast($collection, "array");
    echo json_encode($result, JSON_PRETTY_PRINT);
  }

?>


end