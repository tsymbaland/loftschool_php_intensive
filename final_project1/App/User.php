<?php

namespace App;

use App\AdminViewTrait;
use InvalidArgumentException;
use PDO;

class User
{
	use AdminViewTrait;

	/**  @var PDO */
	private $conn;
	private $fields = [
		'id' => 'ID',
		'email' => 'E-Mail',
		'name' => 'User Name',
		'phone_number' => 'Phone #',
	];

	public function __construct(PDO $conn)
	{
		$this->conn = $conn;
	}

	public function getFields(): array
	{
		return $this->fields;
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
			->query('SELECT * FROM users;')
			->fetchAll(PDO::FETCH_ASSOC);
	}

	public function authByEmail(string $email): ?int
	{
		$this->validateEmail($email);
		$query = $this->conn->prepare(
			'SELECT id FROM users WHERE email = :email;'
		);
		$query->execute(['email' => $email]);
		$result = $query->fetchColumn();

		return $result === false ? null : $result;
	}

	public function create(
		string $email,
		string $name,
		string $phone = ''
	): int {
		$this->validateName($name);
		$this->validatePhone($phone);
		$query = $this->conn->prepare(
			'INSERT INTO users (email, name, phone_number)
 			VALUES (:email, :name, :phone);'
		);
		$query->execute([
			'email' => $email,
			'name' => $name,
			'phone' => $phone,
		]);

		return $this->conn->lastInsertId();
	}

	private function validateEmail($email)
	{
		if (
			!is_string($email) ||
			!filter_var($email, FILTER_VALIDATE_EMAIL)
		) {
			throw new InvalidArgumentException("Invalid email: $email");
		}
	}

	private function validateName($name)
	{
		if (!is_string($name) || !$name) {
			throw new InvalidArgumentException("Invalid name: $name");
		}
	}

	private function validatePhone($phone)
	{
		if (
			$phone &&
			!is_string($phone) &&
			!is_numeric($phone)
		) {
			throw new InvalidArgumentException("Invalid phone: $phone");
		}
	}
}
