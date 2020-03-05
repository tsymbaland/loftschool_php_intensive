<?php

require_once 'GPS.php';
require_once 'AdditionalDriver.php';
require_once 'TariffInterface.php';

abstract class AbstractTariff implements TariffInterface
{
	use GPS, AdditionalDriver {
		GPS::getExtraCost insteadof AdditionalDriver;
		GPS::getExtraCost as gps;
		AdditionalDriver::getExtraCost as additionalDriver;
	}

	/** @var float */
	protected $minPaidTimePeriod = 1;
	/** @var float */
	protected $costPerTimePeriod = 3;
	/** @var float */
	protected $costPerKm = 10;

	/** @var int */
	protected $minAge = 18;
	/** @var int */
	protected $maxAge = 65;

	/** @var array */
	protected $restrictedExtras = [];

	public function __construct(float $distance, float $time, int $age, array $extras)
	{
		$price = $this->calcRidePrice($distance, $time, $age, $extras);
		echo " * distance $distance + time $time + age $age = $price<br>";
	}

	public function calcRidePrice(float $distance, float $time, int $age, array $extras): float
	{
		$this->verifyTime($time);
		$this->verifyAge($age);
		$price =
			$this->calcPriceForDistance($distance) +
			$this->calcPriceForTime($time);
		if ($age <= 21) {
			$price *= 1.1;
		}

		$price += $this->calcExtraPrice($distance, $time, $age, $extras);
		return $price;
	}

	protected function calcPriceForDistance(float $distance)
	{
		return $distance * $this->costPerKm;
	}

	protected function calcPriceForTime(float $time)
	{
		return ($this->modifyTime($time) / $this->minPaidTimePeriod) *
			$this->costPerTimePeriod;
	}

	protected function modifyTime(float $time)
	{
		return $time;
	}

	private function calcExtraPrice(
		float $distance,
		float $time,
		int $age,
		array $extras
	): float {
		$extraPrice = 0;
		foreach ($extras as $extra) {
			if (in_array($extra, $this->restrictedExtras)) {
				echo "Chosen tariff doesn't support {$extra} extra option<br>";
				continue;
			}

			if ($extra === 'gps') {
				$extraPrice += $this->$extra($time);
			} elseif ($extra === 'additionalDriver') {
				$extraPrice += $this->$extra();
			}
		}

		return $extraPrice;
	}

	protected function verifyTime(float $time)
	{
		if ($time <= 0) {
			throw new InvalidArgumentException(
				"You should provide correct ride duration<br>"
			);
		}
	}

	protected function verifyAge(int $age)
	{
		if ($age < $this->minAge || $this->maxAge < $age) {
			throw new InvalidArgumentException(
				"Tariff age restriction: {$this->minAge} - {$this->maxAge} years<br>"
			);
		}
	}
}