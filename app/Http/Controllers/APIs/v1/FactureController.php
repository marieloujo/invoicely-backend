<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFactureRequest;
use App\Models\Facture;
use App\Services\Interfaces\FactureServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FactureController extends Controller
{

    private $factureService;

    /**
     * Instantiate a new RegisterController instance.
     *
     * @param FactureServiceInterface $factureInterface
     */
    public function __construct(FactureServiceInterface $factureInterface)
    {
        $this->factureService = $factureInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->factureService->paginate($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFactureRequest $request)
    {
        return $this->factureService->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Facture $invoice)
    {
        Gate::authorize('manage-facture', $invoice);

        return $this->factureService->find($invoice);
    }

    /**
     * 
     */
    public function download(Facture $invoice)
    {
        return $this->factureService->download($invoice);
    }

}
