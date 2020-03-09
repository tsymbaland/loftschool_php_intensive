<?php

namespace Base;

class AbstractController
{
	public $tplFileName;

	/** @var View */
	public $view;

	public function __construct(string $actionName)
	{
		$this->tplFileName = strtolower($actionName) . '.phtml';
	}

	public function preAction()
	{
	}
}