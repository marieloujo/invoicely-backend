<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\Service;
use App\Services\Interfaces\ServiceServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    /**
     * @var service
     */
    private $serviceService;

    /**
     * Instantiate a new RegisterController instance.
     *
     * @param ServiceServiceInterface $serviceInterface
     */
    public function __construct(ServiceServiceInterface $serviceInterface)
    {
        $this->serviceService = $serviceInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->serviceService->paginate($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        return $this->serviceService->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        Gate::authorize('manage-service', $service);

        return $this->serviceService->find($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        Gate::authorize('manage-service', $service);

        return $this->serviceService->update($service, $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        Gate::authorize('manage-service', $service);

        return $this->serviceService->delete($service);
    }

    /**
     * Retreive prices history
     */
    public function prices(Request $request, Service $service)
    {
        Gate::authorize('manage-service', $service);

        return $this->serviceService->prices($request, $service);
    }

}
