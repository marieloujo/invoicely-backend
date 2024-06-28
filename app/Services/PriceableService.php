<?php

namespace App\Services;

use App\Http\Resources\PriceableResource;
use App\Models\Price;
use Core\Repository\BaseRepository;
use Core\Services\AbstractCrudService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PriceableService extends AbstractCrudService
{

    /**
     * ServiceService constructor.
     *
     * @param BaseRepository $serviceRepository
     */
    public function __construct(BaseRepository $baseRepository)
    {
        parent::__construct($baseRepository, PriceableResource::make([]));
    }

    /**
     * Return paginated list of data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function paginate(Request $request): JsonResponse
    {
        $data = $this->repository->model->where("user_id", auth('api')->id())
                    ->paginate($request->per_page ?? env("PAGINATION_PER_PAGE", 10));

        return $this->success(response: $data);
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
            $model->prices()->save(new Price(['unit_price_excl'   => $request->price]));

            DB::commit();

            return $this->success(
                    response: $this->itemJsonResource->make($model),
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

            if ($request->price && $request->price != $model->price->unit_price_excl) {
                $model->price->status = false;
                $model->price->end_date = now();
                $model->price->save();

                Price::create([
                    'priceable_id'      => $model->id,
                    'priceable_type'    => get_class($model),
                    'unit_price_excl'   => $request->price,
                    'unit_price_incl'   => get_include_taxe_amount($request->price),
                ]);
            }

            $model->refresh();

            DB::commit();

            return $this->success(response: $this->itemJsonResource->make($model));

        } catch (\Throwable $th) {
            DB::rollBack();

            throw new Exception($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $th);
        }
    }

    /**
     * Return paginated list of prices
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function prices(Request $request, Model $model): JsonResponse
    {
        $data = $model->prices()->paginate(
            $request->per_page ?? env("PAGINATION_PER_PAGE", 10)
        );

        return $this->success(response: $data);

    }

}
