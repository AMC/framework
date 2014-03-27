<?php

include 'classes/log.php';
include 'classes/database.php';

include 'controller/controller.php';
include 'model/model.php';


$log = new Log("logs/log.txt");
$database = new Database("test");

$controller = 'Controller';


if (isset($_GET['action']))
  $action = strtolower($_GET['action']);
else
  $action = '';

if (isset($_SERVER['REQUEST_METHOD']))
  $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
else
  $requestMethod = 'get';

$controllerMethod = $requestMethod . ucfirst($action);

header('Content-Type: application/json');

if (method_exists('Controller', $controllerMethod))
  $controller::$controllerMethod();
else
  die("die!");
?>
