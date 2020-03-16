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

	public static function modifyImage(): string
	{
		$targetPic = 'ModifyThisPic.jpg';
		$imgSystemPath = IMAGES_SYSTEM_DIR . $targetPic;
		StaticImage::make($imgSystemPath)
			->rotate(45)
			->resize(200, null, function ($image) {
				$image->aspectRatio();
			})
			->text('ZDRASTE', 50, 50, function($font) {
				$font->size(24);
				$font->color('#7F7');
				$font->align('center');
				$font->valign('top');
				$font->angle(45);
			})
			->save();

		return IMAGES_SERVER_DIR . $targetPic;
	}
}