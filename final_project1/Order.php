<?php
require_once('AdminViewTrait.php');

class Order
{
	use AdminViewTrait;

	/**  @var PDO */
	private $conn;
	private $fields = [
		'id' => 'ID',
		'user_id' => 'User ID',
		'address' => 'Address',
		'comment' => 'Comment',
	];

	public function __construct(PDO $conn)
	{
		$this->conn = $conn;
	}

	public function getAdminView(): string
	{
		return $this->makeAdminViewHtml(
			$this->fields,
			$this->fetchAll()
		);
	}

	public function fetchAll(): array
	{
		return $this->conn
			->query('SELECT * FROM orders;')
			->fetchAll(PDO::FETCH_ASSOC);
	}

	public function create(
		int $userId,
		string $comment = '',
		string $street = '',
		int $house = null,
		int $block = null,
		int $apartment = null,
		int $floor = null
	): int {
		$query = $this->conn->prepare(
			'INSERT INTO orders (user_id, address, comment)
			VALUES (:user_id, :address, :comment);'
		);
		$query->execute([
			'user_id' => $userId,
			'address' => $this->composeAddress(
				$street,
				$house,
				$block,
				$apartment,
				$floor
			),
			'comment' => $comment,
		]);

		return $this->conn->lastInsertId();
	}

	public function makeResponseForLastOrder(int $userId): string
	{
		$numOfOrders = $this->getCountForUser($userId);
		echo "numOfOrders $numOfOrders<br>";
		$msg = $this->composeResponseMsg($numOfOrders);
		$this->logResponse($userId, $numOfOrders, $msg);

		return $msg;
	}

	private function composeAddress(
		string $street = '',
		int $house = null,
		int $block = null,
		int $apartment = null,
		int $floor = null
	): string {
		return "street,$street,house,$house,block,$block,apartment,$apartment,floor,$floor";
	}

	private function getCountForUser(int $userId): int
	{
		$query = $this->conn->prepare(
			'SELECT COUNT(*) FROM orders
			WHERE user_id = :user_id;'
		);
		$query->execute(['user_id' => $userId]);

		return (int)$query->fetchColumn();
	}

	private function composeResponseMsg(int $numOfOrders): string
	{
		$msg = 'DarkBeefBurger за 500 рублей, 1 шт<br>';
		if (1 === $numOfOrders) {
			$msg .= "Спасибо - это ваш первый заказ!<br>";
		} else {
			$msg .= "Спасибо! Это уже $numOfOrders заказ!<br>";
		}

		return $msg;
	}

	private function logResponse(int $userId, int $numOfOrders, string $msg)
	{
		file_put_contents("User #$userId Order #$numOfOrders.txt", $msg);
	}
}
