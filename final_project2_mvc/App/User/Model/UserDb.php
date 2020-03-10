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

		return $result ? new UserEntity($result) : null;
	}

	public function saveUser(UserEntity $user): UserEntity
	{
		$fieldsCfg = array_filter($user->getFields());
		$fields = array_keys($fieldsCfg);
		$queryFields = implode(',', $fields);
		$placeholders = implode(',', array_map(function ($field) {
			return ":$field";
		}, $fields));
		$queryParams = [];
		foreach ($fields as $field) {
			$queryParams[$field] = $user->$field; //попадаем в __get()
		}

		$query = $this->conn->prepare(
			"INSERT INTO users ($queryFields)
			VALUES ($placeholders);"
		);
		$query->execute($queryParams);

		$user->setId($this->conn->lastInsertId());

		return $user;
	}

	// public static function saveUser(UserEntity $user)
	// {
	// 	$data = ['id' => $user->getId(), 'name' => $user->getName()];
	// 	// соединяемся с БД и сохраняем массив в базу
	// }
}