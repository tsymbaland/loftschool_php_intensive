<?php
use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection([
    "driver" => "mysql",
    "host" => "localhost", // "127.0.0.1",
    "database" => "loft_5_7",
    "username" => "mysql",
    "password" => "mysql"
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();