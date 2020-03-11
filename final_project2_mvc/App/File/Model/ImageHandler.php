<?php

namespace App\File\Model;

use Intervention\Image\ImageManagerStatic as StaticImage;

class ImageHandler
{
	public static function saveImageFromUser($imgFileCfg, $email): string
	{
		$newFileName = htmlspecialchars($imgFileCfg['name']);
		$userImgDir = IMAGES_DIR . md5($email);
		if (!file_exists($userImgDir)) {
			mkdir($userImgDir, 666, true);
		}
		$newPath = $userImgDir . DIRECTORY_SEPARATOR . $newFileName;
		StaticImage::make($imgFileCfg['tmp_name'])->save($newPath);

		return $newPath;
	}
}