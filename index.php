<?php header("Location: api/index.php"); ?>

function println($input, $separator = ", ") {
  if (is_array($input))
    echo implode($separator, $input) . PHP_EOL;
  else
    echo $input . PHP_EOL;
  
  echo PHP_EOL;
}

require_once 'config/includes.php';

$m = new Model();


println($m->getClass());
println($m->getMethods(), "\n");
print_r($m->getMethodParameters("setProperties"));

println($m->getProperty("id"));

print_r($m->getProperties());

$m->setProperty("id", "world");
println($m->getProperty("id"));

$m->setProperties(array(
  "id" => "Earth",
  "group" => "not evil",
  "cat" => "dog",
));

print_r($m->getProperties());

$m->save();

echo "<hr>";
//print_r($m);


echo "<hr>end";

