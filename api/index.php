<?php
  require_once 'config/includes.php';

  $database_driver = new MongoDriver($database_config);
  $database = new Database($database_driver);
  $model_factory = new ModelFactory($database);


echo "<pre>";
$m = $model_factory->newModel("Model", array());

echo $m;
//print_r($m);
echo "<hr>";


if ($m->save())
  echo "Saved\n";
else
  echo "An error occured";

echo $m;
//print_r($m);
//$r = $database_driver->find('Model');
//echo $r;

//$m->delete();

/*
*/
