<?php

namespace Core\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Interface AbstractCrudServiceInterface
 * @package Core\Services\Contracts
 */
interface AbstractCrudServiceInterface
{

    /**
     * Return paginated list of data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function paginate(Request $request): JsonResponse;

    /**
     * Get all models.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function all(Request $request): JsonResponse;

    /**
     * Creating new model instance in database
     *
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function create(FormRequest $request): JsonResponse;

    /**
     * Modify existing data
     *
     * @param ?Model $modelId
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function update(?Model $model, FormRequest $request): JsonResponse;

    /**
     * Modify existing data by it's id
     *
     * @param int|string $modelId
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function updateById($modelId, FormRequest $request): JsonResponse;

    /**
     * Find data by it's id
     *
     * @param ?Model $model
     * @param Request $request
     * @return JsonResponse
     */
    public function find(?Model $model): JsonResponse;

    /**
     * Find data by it's id
     *
     * @param int|string $modelId
     * @param Request $request
     * @return JsonResponse
     */
    public function findbyId($modelId, Request $request): JsonResponse;

    /**
     * Delete data by it's id
     *
     * @param ?Model $model
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(?Model $model): JsonResponse;
}
