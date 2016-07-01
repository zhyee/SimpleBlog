<?php

require "vendor/autoload.php";

$swagger = \Swagger\scan(realpath(__DIR__ . '/../frontend/modules/api'));

header("Content-type: application/json");

echo $swagger;