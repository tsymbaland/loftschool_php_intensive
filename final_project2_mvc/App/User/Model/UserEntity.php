<?php

namespace App\User\Model;

use Base\Exception\AbsentClassFieldException;

class UserEntity
{
	/** @var int */
	private $id;
	/** @var string */
	private $email;
	/** @var string */
	private $name;
	/** @var string */
	private $password;
	/** @var int */
	private $age;
	/** @var string */
	private $avatar;
	private $createdAt;
	private $updatedAt;

	protected $fields = [
		'id' => null,
		'email' => 'email',
		'name' => 'name',
		'password' => 'password',
		'age' => 'age',
		'avatar' => 'avatar',
		'created_at' => null,
		'updated_at' => null,
	];

	public function __construct(array $data)
	{
		foreach ($this->fields as $entityField => $inputProperty) {
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

	public function getName()
	{
		return $this->name;
	}

	public function setName(?string $name = ''): UserEntity
	{
		$this->name = $name;
		return $this;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;
		return $this;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): self
	{
		$this->password = sha1($password);
		return $this;
	}

	public function getAge(): ?int
	{
		return $this->age;
	}

	public function setAge(?int $age = null): self
	{
		$this->age = $age;
		return $this;
	}

	public function getAvatar(): ?string
	{
		return $this->avatar;
	}

	public function setAvatar(?string $avatar = null): self
	{
		$this->avatar = $avatar;
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