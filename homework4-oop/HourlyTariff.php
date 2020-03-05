<?php

class HourlyTariff extends AbstractTariff
{
	/** @var float */
	protected $minPaidTimePeriod = 60;
	/** @var float */
	protected $costPerTimePeriod = 200;
	/** @var float */
	protected $costPerKm = 0;

	protected function modifyTime(float $time)
	{
		$excess = fmod($time, $this->minPaidTimePeriod);
		if ($excess) {
			$time += $this->minPaidTimePeriod - $excess;
		}

		return $time;
	}
}