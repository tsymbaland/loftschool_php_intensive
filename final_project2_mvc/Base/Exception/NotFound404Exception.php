<?php

namespace Base\Exception;

class NotFound404Exception extends \Exception
{
	protected $message = '<hr><b>404</b><hr>Page not found!';
}