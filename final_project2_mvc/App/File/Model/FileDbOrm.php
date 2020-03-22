<?php

namespace App\File\Model;

use Base\OrmHelper;
use Illuminate\Support\Collection;

class FileDbOrm
{
	public function checkExistance(array $filters): bool
	{
		return FileEntityOrm::query()
			->where($this->prepareInputParams($filters, true))
			->exists();
	}

	public function create(array $data): FileEntityOrm
	{
		return FileEntityOrm::query()->create(
			$this->prepareInputParams($data)
		);
	}

	public function findBy(array $filters, ?array $sorters = []): Collection
	{
		$query = FileEntityOrm::query()
			->where($this->prepareInputParams($filters, true));
		if (count($sorters)) {
			$orderBy = [];
			foreach ($sorters as $field => $direction) {
				if (!($direction = strtoupper($direction))) {
					$direction = 'ASC';
				}
				$orderBy[] = "$field $direction";
			}
			$query->orderByRaw(implode(',', $orderBy));
		}

		return $query->get();
	}

	public function prepareInputParams(
		array $params,
		bool $prepareFilters = false
	): array {
		if ($prepareFilters) {
			$params = OrmHelper::prepareOrmFilters(
				$params,
				FileEntityOrm::getFieldsMapping()
			);
		}

		return $params;
	}
}