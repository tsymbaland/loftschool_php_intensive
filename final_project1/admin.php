<?php

require_once 'vendor/autoload.php';

use App\Order;
use App\PdoConnection;
use App\User;

$conn = PdoConnection::getConnection();
$user = new User($conn);
$order = new Order($conn);

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, ['cache' => false]);
echo $twig->render('main.html', [
	'orderMeta' => $order->getFields(),
	'userMeta' => $user->getFields(),
	'users' => $user->fetchAll(),
	'orders' => $order->fetchAll()
]);
