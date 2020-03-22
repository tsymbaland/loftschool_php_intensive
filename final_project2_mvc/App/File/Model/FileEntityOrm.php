<?php

namespace App\File\Model;

use App\User\Model\UserEntityOrm;
use Illuminate\Database\Eloquent\Model;

class FileEntityOrm extends Model
{
	public $table = 'files';
	protected $primaryKey = 'id';
	protected $connection = CONN;

	public function userdata()
	{
		$this->belongsTo(UserEntityOrm::class, 'userId', 'id');
	}

	protected $fillable = ['user_id', 'name'];
	protected static $fieldsMapping = [
		'userId' => 'user_id',
	];
	public static function getFieldsMapping(): array
	{
		return self::$fieldsMapping;
	}
}