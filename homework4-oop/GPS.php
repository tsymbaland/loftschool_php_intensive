<?php

trait GPS
{
	public function getExtraCost(float $time)
	{
		$hour = 60;
		if ($time < $hour) {
			echo "GPS only available for rides that are longer than 60 minutes<br>";
			return 0;
		}

		return 15 * $this->modifyTimeGps($time, $hour) / $hour;
	}

	private function modifyTimeGps(float $time, int $hour)
	{
		$excess = fmod($time, $hour);
		if ($excess) {
			$time += $hour - $excess;
		}

		return $time;
	}
}