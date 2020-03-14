<?php

namespace App\File\Model;

use Base\Exception\AbsentClassFieldException;

class FileEntity
{
	/** @var int */
	private $id;
	/** @var int */
	private $userId;
	/** @var string */
	private $name;
	private $createdAt;
	private $updatedAt;

	protected $fields = [
		'id' => null,
		'user_id' => 'userId',
		'name' => 'name',
		'created_at' => null,
		'updated_at' => null,
	];

	// TODO сделать AbstractEntity и занаследовать все Entity от нее
	public function __construct(array $data)
	{
		foreach ($this->fields as $entityField => $inputProperty) {
			// TODO вызывать сеттеры
			$value = $data[$entityField] ?? ($data[$inputProperty] ?? null);
			$this->$entityField = $value;
		}
	}

	public function __get(string $param)
	{
		$getter = 'get' . ucfirst(strtolower($param));
		if (!method_exists($this, $getter)) {
			throw new AbsentClassFieldException(
				"There's no $param field in " . get_class() . 'class'
			);
		}

		return $this->{$getter}();
	}
	public function getFields(): array
	{
		return $this->fields;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId(int $id): self
	{
		$this->id = $id;
		return $this;
	}

	public function getUserId(): int
	{
		return $this->userId;
	}

	public function setUserId(int $userId): void
	{
		$this->userId = $userId;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName(?string $name = ''): FileEntity
	{
		$this->name = $name;
		return $this;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function setCreatedAt($createdAt): self
	{
		$this->createdAt = $createdAt;
		return $this;
	}

	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt($updatedAt): self
	{
		$this->updatedAt = $updatedAt;
		return $this;
	}
}