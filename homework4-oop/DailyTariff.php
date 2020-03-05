<?php

class DailyTariff extends AbstractTariff
{
	/** @var float */
	protected $minPaidTimePeriod = 24 * 60;
	/** @var float */
	protected $costPerTimePeriod = 1000;
	/** @var float */
	protected $costPerKm = 1;

	protected function modifyTime(float $time)
	{
		$excess = fmod($time, $this->minPaidTimePeriod);
		if (
			$time > $this->minPaidTimePeriod &&
			$excess < 30
		) {
			$time -= $excess;
		} else {
			$time += $this->minPaidTimePeriod - $excess;
		}

		return $time;
	}
}