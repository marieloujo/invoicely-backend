<?php

namespace Core\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{

    /**
     * Instanciate Model
     *
     * @return Model
     */
    public function newInstance(): Model;


    /**
     * Create new Model instance filled by payload.
     *
     * @return Model
     */
    public function fill($payload): Model;

    /**
     *
     * @return Model
     */
    public function new($payload): Model;


    /**
     * count all occurence of Model
     *
     * @return int
     */
    public function getCount(): int;

    /**
     * @return Collection
     */
    public function paginate($size = 10);

    /**
     * Get all models.
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(): Collection;


    /**
     * Retrieve models for which a specific column has
     * a value within the defined range.
     *
     * @param string $column
     * @param array $intervalle
     *
     * @return Collection
     */
    public function whereBetween($column, array $intervalle): ?Collection;


    /**
     * Retrieve models where a date colmun has
     * a value equal to the specified value
     *
     * @param string $column
     * @param $value: Y-m-d
     *
     * @return Collection
     */
    public function whereDate($column, $value): ?Collection;


    /**
     * Retrieve models where a date colmun has
     * a month value equal to the specified value
     *
     * @param string $column
     * @param $value: m
     *
     * @return Collection
     */
    public function whereMonth($column, $value): ?Collection;


    /**
     * Retrieve models where a date colmun has
     * a day value equal to the specified value
     *
     * @param string $column
     * @param $value: d
     *
     * @return Collection
     */
    public function whereDay($column, $value): ?Collection;


    /**
     * Retrieve models where a date colmun has
     * a year value equal to the specified value
     *
     * @param string $column
     * @param $value: Y
     *
     * @return Collection
     */
    public function whereYear($column, $value): ?Collection;


    /**
     * Retrieve models where a date colmun has
     * a time value equal to the specified value
     *
     * @param string $column
     * @param $value: H:i:s
     *
     * @return Collection
     */
    public function whereTime($column, $value): ?Collection;


    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed(): Collection;


    /**
     * Get all filtred by
     *
     * @param array $filtres
     * @return Collection
     */
    public function allFiltredBy(array $filtres) : Collection;

    /**
     * Filter data from database
     *
     * @param array $filtres
     * @return void
     */
    public function filter(array $filtres);

    /**
     * Find model by id.
     *
     * @param int|string $modelId
     * @return Model
     */
    public function findById($modelId): ?Model;


    /**
     * Verify if model exist by id
     *
     * @param int|string $modelId
     * @return boolean
     */
    public function existsById($modelId, bool $isDeleted): bool;


    /**
     * Find model by attribut.
     *
     * @param string $attributName
     * @param string $attributValue
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Model
     */
    public function findByAttribute(
        string $attributName,
        string $attributValue,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model;


    /**
     * Find trashed model by id.
     *
     * @param int|string $modelId
     * @return Model
     */
    public function findTrashedById($modelId): ?Model;

    /**
     * Find only trashed model by id.
     *
     * @param int|string $modelId
     * @return Model
     */
    public function findOnlyTrashedById($modelId): ?Model;

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model;

    /**
     * Update existing model by it id
     *
     * @param int|string $modelId
     * @param array $payload
     * @return null|Model
     */
    public function updateById($modelId, array $payload): ?Model;

    /**
     * Update existing model
     *
     * @param int|string
     * @param array $payload
     * @return null|Model
     */
    public function update(Model $model, array $payload): ?Model;

    /**
     * Delete model by id.
     *
     * @param int|string $modelId
     * @return bool
     */
    public function deleteById($modelId): bool;

    /**
     * Restore model by id.
     *
     * @param int|string $modelId
     * @return null|Model
     */
    public function restoreById($modelId): ?Model;

    /**
     * Permanently delete model by id.
     *
     * @param int|string $modelId
     * @return bool
     */
    public function permanentlyDeleteById($modelId): bool;
}
