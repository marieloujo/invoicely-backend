<?php

namespace App\Services;

use App\Enums\TypeTransaction;
use App\Http\Resources\FactureResource;
use App\Models\Client;
use App\Models\FactureItem;
use App\Models\Product;
use App\Repositories\FactureRepository;
use Core\Services\AbstractCrudService;
use App\Services\Interfaces\FactureServiceInterface;
use App\Services\Interfaces\TransactionServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class FactureService extends AbstractCrudService implements FactureServiceInterface
{

    private $transactionService;

    /**
     * FactureService constructor.
     *
     * @param FactureRepository $factureRepository
     */
    public function __construct(FactureRepository $factureRepository,
        TransactionServiceInterface $transactionService)
    {
        parent::__construct($factureRepository);
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

            $clientId = $request->client['id'] ?? Client::create($request->client)->id;

            $facture = $this->repository->create(["client_id" => $clientId]);

            foreach ($request->items as $item) {

                $product = Product::find($item['id']);
                $quantity = floatval($item['quantity']);
                $price = $product->price;

                $factureItem = FactureItem::create([
                    'facture_id' => $facture->id,
                    'price_id' => $price->id,
                    'quantity' => $quantity,
                    'total_amount_excl' => $price->unit_price_excl * $quantity,
                    'total_amount_incl' => $price->unit_price_incl * $quantity,
                ]);

                $this->transactionService->store($factureItem, $product, TypeTransaction::SALES, $quantity);
            }

            DB::commit();

            return $this->success(response: $facture, code: Response::HTTP_CREATED);

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


        return $this->success(response: FactureResource::make($model));
    }

}
