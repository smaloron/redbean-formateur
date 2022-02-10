<?php
require "vendor/autoload.php";

use RedBeanPHP\R as R;

R::setup(
    "mysql:host=localhost;dbname=redbean;charset=utf8",
    "root",
    "1234"
);

$person = R::dispense("person");
$person->lastName = "Brahé";
$person->firstname = "Tycho";

R::store($person);

var_dump($person);

