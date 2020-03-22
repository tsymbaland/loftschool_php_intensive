<?php

namespace App\User\Model;

use App\File\Model\FileEntityOrm;
use Base\Exception\AuthorizationException;
use Illuminate\Database\Eloquent\Model;

class UserEntityOrm extends Model
{
	public $table = 'users';
	protected $primaryKey = 'id';
	protected $connection = CONN;

	public function files () {
		$this->hasMany(FileEntityOrm::class, 'user_id', 'id');
	}

	protected $fillable = ['email', 'name', 'password', 'age', 'avatar'];
	protected static $fieldsMapping = [];
	public static function getFieldsMapping(): array
	{
		return self::$fieldsMapping;
	}

	public const SALT = 'efg23h4WhaHFOWE68';
	public static function hashPassword(string $password): string
	{
		return sha1($password . self::SALT);
	}


	/** @throws AuthorizationException */
	public static function validateInputOnSignup(array $data)
	{
		$p1 = $data['password'] ?? false;
		$p2 = $data['password2'] ?? false;
		if (!$p1 || !$p2 || $p1 !== $p2) {
			throw new AuthorizationException(
				'Both password fields must be filled with same values'
			);
		}
		if (!filter_var($data['email'] ?? false, FILTER_VALIDATE_EMAIL)) {
			throw new AuthorizationException('You should provide valid email');
		}
	}
}