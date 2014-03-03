<?php

$filename = 'log/log.txt';
$message  = "api.php: \n";

foreach ($_SERVER as $key => $value)
  $message .= "$key => $value \n";

file_put_contents($filename, date ('m-d H:i:s') . ": " . $message . "\n\n\n", FILE_APPEND);

echo "api.php\n";
echo $_SERVER['REQUEST_METHOD'];

#TODO: authenticate
#TODO: authorize

require 'controller/controller.php';

$action = $_SERVER['REQUEST_METHOD'];

#try catch action
Controller::$action();

#create Controller
#create params
#Controller::Method($params);
