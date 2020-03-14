<?php

namespace Base;

use PDO;
use PDOException;

class PdoConnection
{
	//TODO надо бы вынести в условный env, но пока лень
	private static $cfg = [
		'host' => 'localhost',
		'dbname' => 'loft_mvc',
		'user' => 'loft',
		'password' => 'loft',
	];
	/** @var PDO */
	private static $conn;

	private function __construct()
	{
	}

	private function __clone()
	{
	}

	public static function getConnection(): PDO
	{
		if (!self::$conn) {
			$cfg = self::$cfg;
			try {
				self::$conn = new PDO(
					"mysql:host={$cfg['host']};dbname={$cfg['dbname']}",
					$cfg['user'],
					$cfg['password']
				);
				self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo $e->getMessage();
				die;
			}
		}

		return self::$conn;
	}
}