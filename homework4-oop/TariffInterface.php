<?php

interface TariffInterface
{
	public function calcRidePrice(float $distance, float $time, int $age, array $extras);
}