<?php

namespace Base;

use Base\Exception\AuthorizationException;
use Base\PdoConnection;
use Base\View;
use Exception;

class Application
{
	// private $config;
	/** @var Context */
	private $context;
	/** @var Request */
	private $request;

	public function __construct()
	{
		// $this->config = $config;
		$this->context = Context::getInstance(); // глобальный контекст
	}

	/** @throws \Exception */
	public function run()
	{
		try {
			$this->context->initSession();
			// $this->context->setConn(PdoConnection::getConnection());
			$this->context->setRequest(new Request());

			$this->request = $this->context->getRequest();

			$dispatcher = new Dispatcher();
			$controller = $dispatcher->makeController();
			$fullActionName = $dispatcher->getFullActionName();

			// проверяем существование метода
			if (!method_exists($controller, $fullActionName)) {
				throw new Exception(
					"Action $fullActionName not found in controller " .
					$dispatcher->getControllerName()
				);
			}

			$view = new View($dispatcher->getTemplateDir());
			// echo"<pre>";var_dump($view, $controller);die;

			$controller->view = $view;
			$controller->$fullActionName($this->request->getUserData());

			echo $view->render($controller->tplFileName);

		} catch (AuthorizationException $e) {
			$view = new View($dispatcher->getTemplateDir(true));
			$view->messages = [$e->getMessage()];
			echo $view->render($dispatcher::DEFAULT_ACTION . '.phtml');
		} catch (Exception $e) {
			echo 'Произошло исключение: ' . $e->getMessage();
			// обработка исключений самого базового уровня - редирект на 404.html
		}
	}
}