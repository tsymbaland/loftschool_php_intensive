<?php

namespace App\User\Model;

use Base\Exception\AuthorizationException;
use Base\OrmHelper;
use Illuminate\Support\Collection;

class UserDbOrm
{
	/** @throws AuthorizationException */
	public function checkIfEmailIsPresent(string $email)
	{
		if ($this->checkExistance(['email' => $email])) {
			throw new AuthorizationException(
				'User with specified email already exists'
			);
		}
	}

	/** @throws AuthorizationException */
	public function findUserByPassword(string $email, string $password): UserEntityOrm
	{
		$users = $this->findBy([
			'email' => $email,
			'password' => $password
		]);
		if (!$users->count()) {
			throw new AuthorizationException(
				'You have provided wrong email and/or password.'
			);
		}

		return $users->get(0);
	}

	public function checkExistance(array $filters): bool
	{
		return UserEntityOrm::query()
			->where($this->prepareInputParams($filters, true))
			->exists();
	}

	public function create(array $data): UserEntityOrm
	{
		return UserEntityOrm::query()->create(
			$this->prepareInputParams($data)
		);
	}

	public function findBy(array $filters, ?array $sorters = []): Collection
	{
		$query = UserEntityOrm::query()
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

	public function edit(UserEntityOrm $user, array $data)
	{
		$data = $this->prepareInputParams($data);
		foreach ($user->getFillable() as $field) {
			if (($data[$field] ?? false) ?: false) {
				$user->$field = $data[$field];
			}
		}

		$user->save();
	}

	public function prepareInputParams(
		array $params,
		bool $prepareFilters = false
	): array {
		if ($password = $params['password'] ?? false) {
			$params['password'] = UserEntityOrm::hashPassword($password);
		}
		if ($prepareFilters) {
			$params = OrmHelper::prepareOrmFilters(
				$params,
				UserEntityOrm::getFieldsMapping()
			);
		}

		return $params;
	}
}