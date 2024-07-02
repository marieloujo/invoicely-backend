<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use Core\Services\AbstractCrudService;
use App\Services\Interfaces\ClientServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientService extends AbstractCrudService implements ClientServiceInterface
{

    /**
     * ClientService constructor.
     *
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        parent::__construct($clientRepository);
    }

    /**
     * Return paginated list of data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function paginate(Request $request): JsonResponse
    {
        $data = $this->repository->model
                    ->orderBy('last_name')
                    ->orderBy('first_name')
                    ->paginate($request->per_page ?? env("PAGINATION_PER_PAGE", 10));

        return $this->success(response: $data);
    }

}
