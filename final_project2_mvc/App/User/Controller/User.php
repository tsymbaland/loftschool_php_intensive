<?php

namespace App\User\Controller;

use App\User\Model\UserDb;
use Base\AbstractController;

class User extends AbstractController
{
	public function preAction()
	{// if () {}
	}

	function indexAction()
	{// Во view тут ничего класть не нужно, просто отображаем
	}

	public function signupAction(array $data)
	{
		$this->validateInputOnSignup($data);
		$db = new UserDb();
		$db->getByEmail($data['email']);
	}

	private function validateInputOnSignup(array $data)
	{
		$p1 = $data['password'] ?? false;
		$p2 = $data['password2'] ?? false;
		if (!$p1 || !$p2 || $p1 !== $p2) {
			throw new \InvalidArgumentException(
				'Both password fields must be filled with same values'
			);
		}
		if (!filter_var($data['email'] ?? false, FILTER_VALIDATE_EMAIL)) {
			throw new \InvalidArgumentException('You should provide valid email');
		}
	}

	// function testAction()
	// {
	// 	$userModel = UserDb::getModelById(1);
	// 	UserDb::saveUser($userModel);
	// 	$this->view->user = $userModel;
	//
	// 	$footerView = clone $this->view;
	// 	$footerView->conters = [1, 2, 3];
	// 	$footerView->setTemplatePath('');
	// 	$this->view->footerTpl = $footerView->render('footer.phtml');
	// }
}