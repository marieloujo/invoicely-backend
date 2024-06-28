<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supply\StoreSupplyRequest;
use App\Models\Supply;
use App\Services\Interfaces\SupplyServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SupplyController extends Controller
{
    private $supplyService;

    /**
     * Instantiate a new RegisterController instance.
     *
     * @param SupplyServiceInterface $supplyInterface
     */
    public function __construct(SupplyServiceInterface $supplyInterface)
    {
        $this->supplyService = $supplyInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->supplyService->paginate($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplyRequest $request)
    {
        return $this->supplyService->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supply $supply)
    {
        Gate::authorize('manage-supply', $supply);

        return $this->supplyService->find($supply);
    }

}
