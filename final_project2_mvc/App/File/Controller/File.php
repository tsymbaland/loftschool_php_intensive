<?php

namespace App\File\Controller;

use App\File\Model\FileDbOrm;
use App\File\Model\FileEntity;
use App\File\Model\ImageHandler;
use Base\AbstractController;
use Base\Context;

class File extends AbstractController
{
	public function uploadAction(array $data)
	{
		$user = Context::getInstance()->getUser();
		$data['userId'] = $user->id;
		$photo = $data['files']['photo'];
		if (!$photo['tmp_name']) die;

		$data['name'] = ImageHandler::saveImageFromUser(
			$photo,
			$user->getEmail()
		);
		(new FileDbOrm())->create(new FileEntity($data));
	}

	public function galleryAction()
	{
		$db = new FileDbOrm();
		$user = Context::getInstance()->getUser();
		$photos = $db->findBy(['userId' => $user->id])->toArray();
		$photos = array_map(function ($photo) {
			return $photo['name'];
		}, $photos);
		if ($avatar = $user->getAvatar()) {
			array_unshift($photos, $avatar);
		}
		$this->view->photos = $photos;
	}

	public function modifyAction(array $data)
	{
		$serverImgPath = ImageHandler::modifyImage();
		$this->view->photo = $serverImgPath;
	}
}
