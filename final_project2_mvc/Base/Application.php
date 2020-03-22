<?php

namespace Base;

use Base\Exception\AuthorizationException;
use Base\Exception\NotFound404Exception;
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
				throw new NotFound404Exception();
			}

			$view = new View($dispatcher->getTemplateDir());
			// echo"<pre>";var_dump($view, $controller);die;

			$controller->view = $view;
			$controller->$fullActionName($this->request->getUserData());

			echo $view->render($controller->tplFileName);

		} catch (AuthorizationException $e) {
			$this->onException(
				$e,
				$e->getMessage(),
				$dispatcher::DEFAULT_ACTION,
				$dispatcher
			);
		} catch (NotFound404Exception $e) {
			$this->onException(
				$e,
				$e->getMessage(),
				$dispatcher::EXCEPTION_DEFAULT_ACTION,
				$dispatcher
			);
		} catch (Exception $e) {
			$this->onException(
				$e,
				'Произошло исключение: ' . $e->getMessage(),
				$dispatcher::EXCEPTION_DEFAULT_ACTION,
				$dispatcher
			);
		}
	}

	private function onException(
		Exception $e,
		string $message,
		string $action,
		Dispatcher $dispatcher
	) {
		$view = new View($dispatcher->getTemplateDir($e));
		$view->messages = [$message];
		echo $view->render("$action.phtml");
	}
}