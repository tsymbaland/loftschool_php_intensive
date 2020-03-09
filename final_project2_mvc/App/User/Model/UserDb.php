<?php

namespace App\User\Model;

use Base\PdoConnection;
use PDO;

class UserDb
{
	/**  @var PDO */
	private $conn;

	public function __construct()
	{
		$this->conn = PdoConnection::getConnection();
	}

	public function getByEmail(string $email): ?UserEntity
	{
		$query = $this->conn->prepare('SELECT * FROM users WHERE email = :email;');
		$query->execute(['email' => $email]);
		$result = $query->fetch(PDO::FETCH_ASSOC);
		var_dump('!!', $result, 123);die;

		return new UserEntity($userData);
	}

	// public static function saveUser(UserEntity $user)
	// {
	// 	$data = ['id' => $user->getId(), 'name' => $user->getName()];
	// 	// соединяемся с БД и сохраняем массив в базу
	// }
}