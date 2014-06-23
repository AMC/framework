<?php
  require_once 'config/includes.php';

  $database_driver = new MongoDriver($database_config);
  $database = new Database($database_driver);
  $model_factory = new ModelFactory($database);


echo "<pre>";

$m = $model_factory->newModel("Blog");
/*
$m->setProperties(array(
  "author" => "Andrew Canfield",
  "date" => "2014-06-23",
  "post" => "First post!",
));

$m->addTag("Awesome");
$m->addTag("Amazing");
$m->addTag("Spectacular");

$c = $model_factory->newModel("Comment");
$c->setProperties(array(
  "author" => "Internet Troll",
  "date" => "2014/06/23",
  "comment" => "I hate you!",
));

$m->addComment($c);

$c = $model_factory->newModel("Comment");
$c->setProperties(array(
  "author" => "Internet Knight",
  "date" => "2014 06 23",
  "comment" => "I hate you more!",
));

$m->addComment($c);

echo $m;

$m->save();
/*
/*
*/

$c = $model_factory->newModel("Comment");
$c->setProperties(array(
  "author" => "Internet King",
  "date" => "2014 06 23",
  "comment" => "I R WEASEL!",
));



foreach ($model_factory->find("Blog") as $m) {
  $m->addComment($c);
  echo "$m <hr>";
  $m->save();
}

/*
$m = $model_factory->newModel("Model", array());

echo $m;

$m->setProperty('data', "mauler");

echo $m;

$m->save();
/*
//print_r($m);
echo "<hr>";


if ($m->save())
  echo "Saved\n";
else
  echo "An error occured";

echo $m;
//print_r($m);
$m->delete();

/*
*/