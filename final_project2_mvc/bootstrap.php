<?php
use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection([
    "driver" => "mysql",
    // "host" => "127.0.0.1",
    "host" => "localhost",
    "database" => "loft_mvc",
    "username" => "loft",
    "password" => "loft"
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();