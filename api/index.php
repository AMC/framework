<?php

include 'classes/log.php';
include 'classes/database.php';
include 'classes/request.php';

include 'controller/controller.php';
include 'model/model.php';


$log = new Log("logs/log.txt");
$request = new Request();

# TODO: variable syntax
# initial syntax:
# :controller/:id
#  options/params submitted as json request

echo $request;





?>
