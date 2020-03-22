<?php

namespace Base;

class OrmHelper
{
	public static function prepareOrmFilters(array $filters, array $mapping): array
	{
		$prepared = [];
		$filters = self::mapFilters($filters, $mapping);
		foreach ($filters as $param => $value) {
			if ($mapped = $mapping[$param] ?? false) {
				$param = $mapped;
			}
			if (self::isFullFilterConfig($value)) {
				$prepared[] = [
					$param,
					$value['operator'],
					$value['value'],
				];
			} else {
				$prepared[] = [$param, '=', $value];
			}
		}

		return $prepared;
	}

	private static function mapFilters(array $filters, array $mapping): array
	{
		$mappedFilters = [];
		foreach ($filters as $param => $value) {
			$key = $mapping[$param] ?? $param;
			$mappedFilters[$key] = $value;
		}

		return $mappedFilters;
	}

	private static function isFullFilterConfig($value): bool
	{
		return is_array($value) &&
			isset($value['operator']) &&
			isset($value['value']);
	}
}