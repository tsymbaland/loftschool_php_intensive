<?php

class PdoConnection
{
	private static $cfg = [
		'host' => 'localhost',
		'dbname' => 'loft1',
		'user' => 'mysql',
		'password' => 'mysql',
	];
	/** @var PDO */
	private static $conn;

	private function __construct()
	{
		$cfg = self::$cfg;
		try {
			self::$conn = new PDO(
				"mysql:host={$cfg['host']};dbname={$cfg['dbname']}",
                $cfg['user'],
                $cfg['password']
            );
        } catch (PDOException $e) {
			echo $e->getMessage();
			die;
		}
	}

	public static function getConnection(): PDO
	{
		if (!self::$conn) {
			new self;
		}

		return self::$conn;
	}
}