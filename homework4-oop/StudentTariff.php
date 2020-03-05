<?php

class StudentTariff extends AbstractTariff
{
	/** @var float */
	protected $costPerTimePeriod = 1;
	/** @var float */
	protected $costPerKm = 4;
	/** @var int */
	protected $maxAge = 25;
	/** @var array */
	protected $restrictedExtras = ['additionalDriver'];
}