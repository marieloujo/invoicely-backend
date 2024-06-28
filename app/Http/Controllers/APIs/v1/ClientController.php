<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Services\Interfaces\ClientServiceInterface;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    /**
     * @var clientService
     */
    private $clientService;

    /**
     * Instantiate a new RegisterController instance.
     *
     * @param ClientServiceInterface $clientServiceInterface
     */
    public function __construct(ClientServiceInterface $clientServiceInterface)
    {
        $this->clientService = $clientServiceInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->clientService->paginate($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        return $this->clientService->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return $this->clientService->find($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        return $this->clientService->update($client, $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        return $this->clientService->delete($client);
    }
}
