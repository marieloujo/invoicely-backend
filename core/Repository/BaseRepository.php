<?php

namespace Core\Repository;

use Core\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{

    /**
     * @var Model
     */
    public $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }


    /**
     *  Instanciate Model
     *  @return Model
        */
    public function newInstance() : Model
    {
        return $this->model->newInstance();
    }

    /**
     * Create new Model instance filled by payload.
     *
     * @return Model
     */
    public function fill($payload): Model
    {
        return $this->model->fill($payload);
    }

    /**
     *
     * @return Model
     */
    public function new($payload): Model
    {
        return new $this->model($payload);
    }


    /**
     * count all occurence of Model
     *
     * @return int
    */
    public function getCount() : int
    {
        return $this->model->count();
    }


    /**
     * get last record of Model
     *
     * @return Model
     */
    public function lastRecord(): Model
    {
        return $this->model->latest("created_at")->first();
    }


    /**
     * @param array $columns
     * @param array $relations
     * @return
     */
    public function paginate($size = 10)
    {
        return $this->model->orderBy('created_at', 'desc')->paginate($size);
    }


    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }


    /**
     * Retrieve models for which a specific column has
     * a value within the defined range.
     *
     * @param string $column
     * @param array $intervalle
     *
     * @return Collection
     */
    public function whereBetween($column, array $intervalle): ?Collection
    {
        return $this->model->whereBetween($column, $intervalle)->get();
    }

    /**
     * Retrieve models where a date colmun has
     * a value equal to the specified value
     *
     * @param string $column
     * @param $value: Y-m-d
     *
     * @return Collection
     */
    public function whereDate($column, $value): ?Collection
    {
        return $this->model->whereDate($column, $value)->get();
    }


    /**
     * Retrieve models where a date colmun has
     * a month value equal to the specified value
     *
     * @param string $column
     * @param $value: m
     *
     * @return Collection
     */
    public function whereMonth($column, $value): ?Collection
    {
        return $this->model->whereMonth($column, $value)->get();
    }


    /**
     * Retrieve models where a date colmun has
     * a day value equal to the specified value
     *
     * @param string $column
     * @param $value: d
     *
     * @return Collection
     */
    public function whereDay($column, $value): ?Collection
    {
        return $this->model->whereDay($column, $value)->get();
    }


    /**
     * Retrieve models where a date colmun has
     * a year value equal to the specified value
     *
     * @param string $column
     * @param $value: Y
     *
     * @return Collection
     */
    public function whereYear($column, $value): ?Collection
    {
        return $this->model->whereYear($column, $value)->get();
    }


    /**
     * Retrieve models where a date colmun has
     * a time value equal to the specified value
     *
     * @param string $column
     * @param $value: H:i:s
     *
     * @return Collection
     */
    public function whereTime($column, $value): ?Collection
    {
        return $this->model->whereTime($column, $value)->get();
    }


    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed(): Collection
    {
        return $this->model->onlyTrashed()->orderBy('created_at', 'desc')->get();
    }


    /**
     * Get all filtred by
     *
     * @param array $filtres => {
     *      column =>
     *      value =>
     *      operator =>
     * }
     * @return Collection
     */
    public function allFiltredBy(array $filtres) : Collection {

        $collection = collect();

        foreach ($filtres as $key => $filtre) {

            if($key == 0)

                $collection = $this->model->where( $filtre['column'], $filtre['operator'], $filtre['value'] );

            else $collection->where( $filtre['column'], $filtre['operator'], $filtre['value'] );

        }

        return $collection->get();

    }


    public function filter(array $filtres)
    {
        $query = null;

        foreach ($filtres as $key => $filtre) {

            if (!is_array($filtre))

                is_null($query)
                ? $query = $this->model->where($key, 'LIKE', '%'.$filtre.'%')
                : $query = $query->orwhere($key, 'LIKE', '%'.$filtre.'%');
        }

        return $query;

    }


    /**
     * Find model by id.
     *
     * @param int|string $modelId
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Model
     */
    public function findById($modelId): ?Model {

        return $this->model->findOrFail($modelId);
    }

    /**
     * Verify if model exist by id
     *
     * @param int|string $modelId
     * @return boolean
     */
    public function existsById($modelId, bool $isDeleted): bool {
        if($isDeleted)
            return $this->model->where('id', $modelId)->whereNotNull('deleted_at')->exists();

        return $this->model->where('id', $modelId)->exists();
    }

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
    ): ?Model {

        return $this->model->select($columns)->with($relations)
                                ->where( $attributName, $attributValue )->first();
    }


    /**
     * Find trashed model by id.
     *
     * @param int|string
     * @return Model
     */
    public function findTrashedById($modelId): ?Model
    {
        return $this->model->withTrashed()->where('id', $modelId)->first();
    }

    /**
     * Find only trashed model by id.
     *
     * @param int|string
     * @return Model
     */
    public function findOnlyTrashedById($modelId): ?Model
    {
        return $this->model->onlyTrashed()->where('id', $modelId)->first();
    }

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model
    {
        return $this->model->create($payload);
    }

    /**
     * Update existing model by it id
     *
     * @param int|string
     * @param array $payload
     * @return null|Model
     */
    public function updateById($modelId, array $payload): ?Model
    {
        $model = $this->findById($modelId);

        $model->update($payload);

        return $model->fresh();
    }

    /**
     * Update existing model
     *
     * @param int|string
     * @param array $payload
     * @return null|Model
     */
    public function update(Model $model, array $payload): ?Model
    {
        $model->update($payload);

        return $model->fresh();
    }

    /**
     * Delete model by id.
     *
     * @param int|string
     * @return bool
     */
    public function deleteById($modelId): bool
    {
        $model = $this->findById($modelId);

        return $model->delete();
    }

    /**
     * Restore model by id.
     *
     * @param int|string
     * @return null|Model
     */
    public function restoreById($modelId): ?Model
    {

        $model = $this->findOnlyTrashedById($modelId);
        $model->restore();

        return $model->fresh();
    }

    /**
     * Permanently delete model by id.
     *
     * @param int|string
     * @return bool
     */
    public function permanentlyDeleteById($modelId): bool
    {

        $model = $this->findTrashedById($modelId);

        return $model->forceDelete();
    }
}
