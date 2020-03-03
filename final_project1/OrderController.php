<?php

require_once('PdoConnection.php');
require_once('User.php');
require_once('Order.php');

[
	'email' => $email,
	'name' => $name,
	'phone' => $phone,
	'street' => $street,
	'home' => $house,
	'part' => $block,
	'appt' => $apartment,
	'floor' => $floor,
	'comment' => $comment,
] = $_REQUEST;

$conn = PdoConnection::getConnection();
$user = new User($conn);

$userId = $user->authByEmail($email);
if (!is_numeric($userId)) {
	echo "MAKING NEW USER<br>";
	$userId = $user->create($email, $name, $phone);
} else {
	echo "YEAH I KNOW U<br>";
}
echo "userId $userId<br>";

$order = new Order($conn);
$orderId = $order->create(
	$userId,
	$comment,
	$street,
	$house,
	$block,
	$apartment,
	$floor
);
echo "orderId $orderId<br>";
$msg = $order->makeResponseForLastOrder($userId);
$msg .= '<a href="index.html#order-form">Вернуться к форме заказа</a>';
echo $msg;
