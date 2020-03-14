<?php

namespace App\File\Model;

use Base\PdoConnection;
use PDO;

class FileDb
{ //TODO сделать абстрактный репозиторий с findAll() findBy()
	/**  @var PDO */
	private $conn;

	public function __construct()
	{
		$this->conn = PdoConnection::getConnection();
	}

	// TODO переделать в findBy
	public function getByUser(int $userId): array
	{
		$query = $this->conn->prepare('SELECT * FROM files WHERE user_id = :user_id;');
		$query->execute(['user_id' => $userId]);

		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function create(FileEntity $file): FileEntity
	{
		$fieldsCfg = array_filter($file->getFields());
		$fields = array_keys($fieldsCfg);
		$queryFields = implode(',', $fields);
		$placeholders = implode(',', array_map(function ($field) {
			return ":$field";
		}, $fields));
		$queryParams = [];
		foreach ($fields as $field) {
			$queryParams[$field] = $file->$field; //попадаем в __get()
		}

		$query = $this->conn->prepare(
			"INSERT INTO files ($queryFields)
			VALUES ($placeholders);"
		);
		$query->execute($queryParams);

		$file->setId($this->conn->lastInsertId());

		return $file;
	}
}