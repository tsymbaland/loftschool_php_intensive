<?php

namespace Base;

use Exception;

/**
 * Class Dispatcher
 * занимается обработкой запроса и получением нужного контроллера
 * @package Base
 */
class Dispatcher
{
	const DEFAULT_MODULE = 'User';
	const DEFAULT_CONTROLLER = 'User';
	const DEFAULT_ACTION = 'index';

	/** @var bool */
	private $isAuth;
	/** @var Request */
	private $request;

	/** @var string */
	private $moduleName;
	/** @var string */
	private $controllerName;
	/** @var string */
	private $actionName;
	/** @var string */
	private $fullActionName;

	private $predefinedRoutes = [
		'login' => [
			'allowWithoutAuth' => true,
			'parts' => [
				self::DEFAULT_MODULE,
				self::DEFAULT_CONTROLLER,
				'login'
			]
		],
		'signup' => [
			'allowWithoutAuth' => true,
			'parts' => [
				self::DEFAULT_MODULE,
				self::DEFAULT_CONTROLLER,
				'signup'
			]
		],
	];

	public function __construct()
	{
		$context = Context::getInstance();
		$this->isAuth = $context->isAuth();
		$this->request = $context->getRequest();

		$this->dispatch();
	}

	public function dispatch(): self
	{
		$uri = $this->request->getRequestUri();
		$predefinedRoute = $this->predefinedRoutes[$uri] ?? [];
		if (
			$this->isAuth ||
			($predefinedRoute['allowWithoutAuth'] ?? false)
		) {
			$parts =
				$predefinedRoute['parts'] ??
				$this->request->getRequestUriParts();
			$module = $this->toLowerCap(
				$parts[0] ?? self::DEFAULT_MODULE
			);
			$controller = $this->toLowerCap(
				$parts[1] ?? self::DEFAULT_CONTROLLER
			);
			$action = strtolower($parts[2] ?? self::DEFAULT_ACTION);
		} else { // неавторизованных шлем по дефолту
			$module = self::DEFAULT_MODULE;
			$controller = self::DEFAULT_CONTROLLER;
			$action = self::DEFAULT_ACTION;
		}

		$this->moduleName = $module;
		$this->controllerName = $controller;
		$this->actionName = $action;
		$this->fullActionName = $action . 'Action';
		// echo "<pre>";var_dump(
		// 	'$this->isAuth', $this->isAuth,
		// 	'$this->request->getRequestUri()', $this->request->getRequestUri(),
		// 	'$this->request->getRequestUriParts()', $this->request->getRequestUriParts(),
		// 	'$this->request->getUserData()', $this->request->getUserData()
		// 	// '$parts', $parts
		// );

		return $this;
	}

	/** @throws Exception */
	public function makeController(): AbstractController
	{
		$controllerClassName = sprintf(
			'App\\%s\\Controller\\%s',
			$this->moduleName,
			$this->controllerName
		);
		if (!class_exists($controllerClassName)) {
			throw new Exception("Controller {$controllerClassName} not found");
		}

		$controller = new $controllerClassName($this->actionName);
		if (!($controller instanceof AbstractController)) {
			throw new Exception("Controller {$controllerClassName} doesn't implement abstract controller");
		}

		return $controller;
	}

	public function getDefaultTemplateDir()
	{
		$rt = ROOT_DIR;
		$ds = DIRECTORY_SEPARATOR;
		return "{$rt}App{$ds}{$this->moduleName}{$ds}Templates{$ds}{$this->controllerName}";
	}

	public function getControllerName(): ?string
	{
		return $this->controllerName;
	}

	public function getFullActionName(): string
	{
		return $this->fullActionName;
	}

	private function toLowerCap(string $s): string
	{
		return ucfirst(strtolower($s));
	}
}
