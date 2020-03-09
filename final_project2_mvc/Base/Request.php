<?php

namespace Base;

use Exception;

class Request
{

	// private $requestedModule;
	// private $requestedController;
	// private $requestedAction;
	/** @var string|null */
	private $requestUri;
	/** @var array */
	private $requestUriParts;
	/** @var array */
	private $userData;


	/** @throws Exception */
	public function __construct()
	{
		$isAuth = Context::getInstance()->isAuth();

		$this->userData = $_REQUEST;
		$this->requestUri = trim(
			$this->userData['url'] ?? $_SERVER['REQUEST_URI'],
			'/'
		);
		// var_dump($_REQUEST['url'] ?? 'XYX', $_SERVER['REQUEST_URI'], trim(
		// 	$this->userData['url'] ?? $_SERVER['REQUEST_URI'],
		// 	'/'
		// ),$this->requestUri);

		// обрабатываем пользовательский запрос
		$this->handle($isAuth);
	}

	/**
	 * @throws Exception
	 *
	 * Метод обрабатывает пользовательский запрос
	 * Валидирует переданный модуль, контроллер и экшен
	 * Заполняет соответствующие переменные для будущего создания объекта контроллера
	 */
	public function handle(bool $isAuth)
	{
		if ($isAuth) {
			$parts = explode('/', $this->requestUri);

			// if (!$parts || sizeof($parts) < 2) {
			//     $this->requestedModule = self::DEFAULT_MODULE;
			//     $this->requestedController = self::DEFAULT_CONTROLLER;
			//     $this->requestedAction = self::DEFAULT_ACTION;
			// } else {
			foreach ($parts as $i => $part) {
				if (!$this->validate($part)) {
					throw new Exception("Url part #$i is not valid: $part");
				}
			}
			$this->requestUriParts = $parts;
		} else {
			$this->requestUriParts = [];
		}
	}

	// public function getRequestedModule(): ?string
	// {
	// 	return $this->requestedModule;
	// }
	//
	// public function getRequestedController(): ?string
	// {
	// 	return $this->requestedController;
	// }
	//
	// public function getRequestedAction(): ?string
	// {
	// 	return $this->requestedAction;
	// }

	public function getUserData(): array
	{
		return $this->userData;
	}

	public function getRequestUri(): ?string
	{
		return $this-> requestUri;
	}

	public function getRequestUriParts(): array
	{
		return $this->requestUriParts;
	}

	private function validate($urlPart): bool
	{
		return preg_match('/^[a-zA-Z0-9]+$/', $urlPart);
	}
}
