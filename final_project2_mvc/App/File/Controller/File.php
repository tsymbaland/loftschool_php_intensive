<?php

namespace App\File\Controller;

use App\File\Model\FileDb;
use App\File\Model\FileEntity;
use App\File\Model\ImageHandler;
use Base\AbstractController;
use Base\Context;

class File extends AbstractController
{
	public function uploadAction(array $data)
	{
		$user = Context::getInstance()->getUser();
		$data['userId'] = $user->getId();
		$photo = $data['files']['photo'];
		$data['name'] = ImageHandler::saveImageFromUser(
			$photo,
			$user->getEmail()
		);

		$db = new FileDb();
		$db->create(new FileEntity($data));
	}

	public function galleryAction()
	{
		$db = new FileDb();
		$user = Context::getInstance()->getUser();
		$photos = $db->getByUser($user->getId());
		$photos = array_map(function ($photo) {
			return $photo['name'];
		}, $photos);
		if ($avatar = $user->getAvatar()) {
			array_unshift($photos, $avatar);
		}
		$this->view->photos = $photos;
	}
}
