<?php

namespace Base;

use App\User\Model\UserEntityOrm;

class Context
{
	// /** @var \PDO */
	// private $conn;
	private $request;
	/** @var UserEntityOrm */
	private $user;
	/** @var bool */
	private $isAuth;
	/** @var self */
	private static $instance;

	public function initSession()
	{
		session_start();
		$user = null;
		if (isset($_SESSION['userId'])) {
			$user = (UserEntityOrm::query()->find(
				(int)$_SESSION['userId']
			));
		}
		$this->setUser($user);
		$this->setIsAuth((bool)$user);
	}

	// public function getConn(): \PDO
	// {
	// 	return $this->conn;
	// }
	//
	// public function setConn(\PDO $conn): void
	// {
	// 	$this->conn = $conn;
	// }

	public static function getInstance(): self
	{
		if (!self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function getRequest(): Request
	{
		return $this->request;
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

	public function getUser(): ?UserEntityOrm
	{
		return $this->user;
	}

	private function setUser(?UserEntityOrm $user = null)
	{
		$this->user = $user;
	}

	public function isAuth(): bool
	{
		return $this->isAuth;
	}

	public function setIsAuth(bool $isAuth): void
	{
		$this->isAuth = $isAuth;
	}

	private function __construct()
	{
	}

	private function __clone()
	{
	}
}