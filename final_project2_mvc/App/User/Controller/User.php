<?php

namespace App\User\Controller;

use App\User\Model\UserDb;
use App\User\Model\UserEntity;
use Base\AbstractController;
use Base\Exception\AuthorizationException;

class User extends AbstractController
{
	public function preAction()
	{// if () {}
	}

	function indexAction()
	{// Во view тут ничего класть не нужно, просто отображаем
	}

	/** @throws AuthorizationException */
	public function signupAction(array $data)
	{
		$this->validateInputOnSignup($data);
		$db = new UserDb();
		$user = $db->getByEmail($data['email']);
		if ($user) {
			throw new AuthorizationException(
				'User with specified email already exists'
			);
		}

		$user = $db->saveUser(new UserEntity($data));
		$_SESSION['userId'] = $user->getId(); //авторизуем
	}

	/** @throws AuthorizationException */
	private function validateInputOnSignup(array $data)
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