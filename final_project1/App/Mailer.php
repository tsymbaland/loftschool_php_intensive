<?php

namespace App;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Mailer
{
	public function sendEmail(string $message)
	{
		$transport = (new Swift_SmtpTransport('smtp.yandex.ru', 465, 'ssl'))
			->setUsername('@ya.ru')
			->setPassword('');
		$mailer = new Swift_Mailer($transport);
		$message = (new Swift_Message('LoftSchool'))
			->setFrom(['@ya.ru' => 'John Doe'])
			->setTo(['@ya.ru'])
			->setBody($message);
		$mailer->send($message);
	}
}
