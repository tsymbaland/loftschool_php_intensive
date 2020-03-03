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

	'card_payment' => $cardPayment,
] = $_REQUEST;
$cardPayment = filter_var($cardPayment, FILTER_VALIDATE_BOOLEAN);
// Вынужден обработать отдельно, тк если галка снята, этого ключа не будет.
$dontCallBack = filter_var(
	$_REQUEST['dont_call_back'] ?? false,
	FILTER_VALIDATE_BOOLEAN
);

$conn = PdoConnection::getConnection();
$user = new User($conn);

$userId = $user->authByEmail($email);
if (!is_numeric($userId)) {
	$userId = $user->create($email, $name, $phone);
}

$order = new Order($conn);
$orderId = $order->create(
	$userId,

	$cardPayment,
	$dontCallBack,
	$comment,

	$street,
	$house,
	(string)$block,
	$apartment,
	$floor
);
$msg = $order->makeResponseForLastOrder($userId);
$msg .= '<a href="index.html#order-form">Вернуться к форме заказа</a>';
echo $msg;
