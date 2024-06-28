<?php

namespace App\Services;

use App\Enums\TypeTransaction;
use App\Http\Resources\SupplyResource;
use App\Models\Product;
use App\Repositories\SupplyRepository;
use Core\Services\AbstractCrudService;
use App\Services\Interfaces\SupplyServiceInterface;
use App\Services\Interfaces\TransactionServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SupplyService extends AbstractCrudService implements SupplyServiceInterface
{

    private $transactionService;

    /**
     * SupplyService constructor.
     *
     * @param SupplyRepository $supplyRepository
     */
    public function __construct(SupplyRepository $supplyRepository, TransactionServiceInterface $transactionService)
    {
        parent::__construct($supplyRepository);
        $this->transactionService = $transactionService;
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
     * Creating new supply instance in database
     *
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function create(FormRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {

            $supply = $this->repository->create([]);

            foreach ($request->products as $item) {
                $this->transactionService->store(
                    $supply, 
                    Product::find($item['id']),
                    TypeTransaction::STORAGE,
                    floatval($item['quantity'])
                );
            }

            DB::commit();

            return $this->success(response: $supply, code: Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $th);
        }
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


        return $this->success(response: SupplyResource::make($model));
    }
}
