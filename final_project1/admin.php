<?php

use App\Order;
use App\PdoConnection;
use App\User;

$conn = PdoConnection::getConnection();
$user = new User($conn);
$order = new Order($conn);

echo '<pre>';
echo "<hr><h1>Users</h1><br>{$user->getAdminView()}<hr>";
echo "<hr><h1>Orders</h1><br>{$order->getAdminView()}<hr>";
