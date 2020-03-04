<?php

require_once('PdoConnection.php');
require_once('User.php');
require_once('Order.php');

$conn = PdoConnection::getConnection();
$user = new User($conn);
$order = new Order($conn);

echo '<pre>';
echo "<hr><h1>Users</h1><br>{$user->getAdminView()}<hr>";
echo "<hr><h1>Orders</h1><br>{$order->getAdminView()}<hr>";
