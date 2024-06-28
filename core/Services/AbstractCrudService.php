<?php

namespace Core\Services;

use App\Traits\JsonResponseTrait;
use Core\Repository\EloquentRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AbstractCrudService implements AbstractCrudServiceInterface
{

    use JsonResponseTrait;

    /**
     * @var repository
     */
    protected $repository;

    /**
     * @var
     */
    protected $itemJsonResource;

    /**
     * @var
     */
    protected $collectionJsonResource;

    /**
     * AbstractService constructor.
     *
     * @param BaseRepository $repository
     */
    public function __construct(EloquentRepositoryInterface $repository,
                                JsonResource $itemJsonResource = null,
                                JsonResource $collectionJsonResource = null)
    {

        $this->repository = $repository;
        $this->itemJsonResource = $itemJsonResource;
        $this->collectionJsonResource = $collectionJsonResource;
    }


    /**
     * Return paginated list of data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function paginate(Request $request): JsonResponse
    {
        $data = $this->repository->paginate(
            $request->per_page ?? env("PAGINATION_PER_PAGE", 10)
        );

        return $this->success(response: is_null($this->collectionJsonResource)
                        ? $data
                        : $this->collectionJsonResource->make($data)
                    );

    }



    /**
     * Get all models.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function all(Request $request): JsonResponse
    {
        $data = $this->repository->all();

        return $this->success(response: is_null($this->collectionJsonResource)
            ? $data
            : $this->collectionJsonResource->make($data)
        );
    }



    /**
     * Creating new model instance in database
     *
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function create(FormRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {

            $model = $this->repository->create($request->validated());

            DB::commit();

            return $this->success(
                    response: is_null($this->itemJsonResource)
                                            ? $model
                                            : $this->itemJsonResource->make($model),
                    code: Response::HTTP_CREATED
            );

        } catch (\Throwable $th) {
            DB::rollBack();

            throw new Exception($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $th);
        }
    }



    /**
     * Modify existing data
     *
     * @param ?Model $modelId
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function update(?Model $model, FormRequest $request): JsonResponse
    {

        DB::beginTransaction();

        try {

            $model->update($request->validated());

            DB::commit();

            return $this->success(response: is_null($this->itemJsonResource)
                            ? $model
                            : $this->itemJsonResource->make($model));

        } catch (\Throwable $th) {
            DB::rollBack();

            throw new Exception($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $th);
        }
    }



    /**
     * Modify existing data
     *
     * @param int|string $modelId
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function updateById($modelId, FormRequest $request): JsonResponse
    {
        $old_model = $this->repository->findById($modelId);

        DB::beginTransaction();

        try {

            $model = $this->repository->update($old_model, $request->validated());

            DB::commit();

            return $this->success(response: is_null($this->itemJsonResource)
                            ? $model
                            : $this->itemJsonResource->make($model));

        } catch (\Throwable $th) {
            DB::rollBack();

            throw new Exception($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $th);
        }
    }



    /**
     * Find data by it's id
     *
     * @param int|string $modelId
     * @param Request $request
     * @return JsonResponse
     */
    public function findbyId($modelId, Request $request): JsonResponse
    {
        $model = $this->repository->findById($modelId);

        return $this->success(response: is_null($this->itemJsonResource)
                        ? $model
                        : $this->itemJsonResource->make($model)
        );
    }


    /**
     * Find data
     *
     * @param Model $model
     * @return JsonResponse
     */
    public function find(?Model $model): JsonResponse
    {
        if (is_null($model))

            throw (new ModelNotFoundException())->setModel(get_class($this->repository->model));


        return $this->success(response: is_null($this->itemJsonResource)
                        ? $model
                        : $this->itemJsonResource->make($model)
        );
    }


    /**
     * Delete data by it's id
     *
     * @param Model $model
     * @return JsonResponse
     */
    public function delete(?Model $model): JsonResponse
    {
        DB::beginTransaction();

        try {
            $model->delete();

            DB::commit();

            return $this->success();

        } catch (\Throwable $th) {
            DB::rollBack();

            throw new Exception($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $th);
        }
    }

}
