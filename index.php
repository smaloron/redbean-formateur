<?php
require "vendor/autoload.php";

use RedBeanPHP\R as R;

R::setup(
    "mysql:host=localhost;dbname=redbean;charset=utf8",
    "root",
    "1234"
);

$person = R::load("person", 6);


var_dump($person);

