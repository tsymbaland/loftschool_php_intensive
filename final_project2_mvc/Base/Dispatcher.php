<?php

namespace Base;

use Base\Exception\AuthorizationException;
use Base\Exception\NotFound404Exception;
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

	const EXCEPTION_MODULE = 'Exception';
	const EXCEPTION_CONTROLLER = 'Exception';
	const EXCEPTION_DEFAULT_ACTION = 'exception';

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
		'main' => [
			'parts' => [
				self::DEFAULT_MODULE,
				self::DEFAULT_CONTROLLER,
				'main'
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
		$uri = $this->request->getRequestUri() ?: 'main';
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
			throw new NotFound404Exception();
		}

		$controller = new $controllerClassName($this->actionName);
		if (!($controller instanceof AbstractController)) {
			throw new NotFound404Exception();
		}

		return $controller;
	}

	public function getTemplateDir(?Exception $e = null)
	{
		if ($e) {
			if ($e instanceof AuthorizationException) {
				$moduleName = $this::DEFAULT_MODULE;
				$controllerName = $this::DEFAULT_CONTROLLER;
			} else {
				$moduleName = $this::EXCEPTION_MODULE;
				$controllerName = $this::EXCEPTION_CONTROLLER;
			}
		} else {
			$moduleName = $this->moduleName;
			$controllerName = $this->controllerName;
		}
		$rt = ROOT_DIR;
		$ds = DIRECTORY_SEPARATOR;
		return "{$rt}App{$ds}{$moduleName}{$ds}Templates{$ds}{$controllerName}";
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
