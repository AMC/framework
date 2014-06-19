<?php
  require_once 'config/includes.php';

  $database_driver = new MongoDriver($database_config);
  $database = new Database($database_driver);
  $model_factory = new ModelFactory($database);


echo "<pre>";
//$m = $model_factory->newModel("Model", array());
/*
if ($m->save())
  echo "Saved\n";
else
  echo "An error occured";
*/

$r = $database_driver->find('Model');
foreach ($r as $s)
  echo json_encode($s, JSON_PRETTY_PRINT);

//$m->delete();