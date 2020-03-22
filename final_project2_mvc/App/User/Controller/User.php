<?php

namespace App\User\Controller;

use App\File\Model\ImageHandler;
use App\User\Model\UserDbOrm;
use App\User\Model\UserEntityOrm;
use Base\AbstractController;
use Base\Exception\AuthorizationException;

class User extends AbstractController
{
	public function preAction()
	{
	}

	function indexAction()
	{// Во view тут ничего класть не нужно, просто отображаем
	}
	function mainAction()
	{// Во view тут ничего класть не нужно, просто отображаем
	}

	/** @throws AuthorizationException */
	public function signupAction(array $data)
	{
		$this->makeNewUser($data, true);
	}

	/** @throws AuthorizationException */
	public function loginAction(array $data)
	{
		$user = (new UserDbOrm())->findUserByPassword(
			$data['email'],
			$data['password']
		);
		$_SESSION['userId'] = $user->getAttribute('id'); //авторизуем
	}

	public function adminAction(array $data)
	{
		if ($data['create'] ?? false) {
			$this->makeNewUser($data);
			$this->view->message = '<b>New user has been created!</b>';
		} elseif ($data['edit'] ?? false) {
			$db = new UserDbOrm();
			$user = $db->findUserByPassword(
				$data['email'],
				$data['password']
			);
			$data = $this->saveImageFromUser($data);
			$db->edit($user, $data);
			$this->view->message = '<b>User has been edited successfully!</b>';
		}
	}

	public function listAction(array $data)
	{
		$users = (new UserDbOrm())
			->findBy(
				[],
				['id' => $data['sort'] ?? ''],
			);
		$this->view->users = $users->toArray();
	}

	/** @throws AuthorizationException */
	public function makeNewUser(array $data, bool $rememberInSession = false)
	{
		$db = new UserDbOrm();
		UserEntityOrm::validateInputOnSignup($data);
		$db->checkIfEmailIsPresent($data['email']);

		$data = $this->saveImageFromUser($data);
		$user = $db->create($data);
		if ($rememberInSession) {
			$_SESSION['userId'] = $user->id; //авторизуем
		}
	}

	/** @throws AuthorizationException */
	public function saveImageFromUser(array $data, bool $rememberInSession = false)
	{
		$avatar = $data['files']['avatar'];
		if ($avatar['tmp_name']) {
			$data['avatar'] =
				ImageHandler::saveImageFromUser($avatar, $data['email']);
			unset($data['files']);
		}

		return $data;
	}
}