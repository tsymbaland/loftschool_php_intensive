<?php

namespace App\File\Model;

use Intervention\Image\ImageManagerStatic as StaticImage;

class ImageHandler
{
	public static function saveImageFromUser($imgFileCfg, $email): string
	{
		$ds = DIRECTORY_SEPARATOR;
		$newFileName = htmlspecialchars($imgFileCfg['name']);
		$email = md5($email);
		$userImgSystemDir = IMAGES_SYSTEM_DIR . $email;
		if (!file_exists($userImgSystemDir)) {
			mkdir($userImgSystemDir, 666, true);
		}
		$newSystemPath = $userImgSystemDir . $ds . $newFileName;
		StaticImage::make($imgFileCfg['tmp_name'])
			->rotate(0) // удаляем зловредный код
			->save($newSystemPath);

		return IMAGES_SERVER_DIR . $email . $ds . $newFileName;
	}
}