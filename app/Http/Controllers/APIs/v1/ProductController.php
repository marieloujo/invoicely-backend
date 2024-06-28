<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * @var product
     */
    private $productService;

    /**
     * Instantiate a new RegisterController instance.
     *
     * @param ProductServiceInterface $productInterface
     */
    public function __construct(ProductServiceInterface $productInterface)
    {
        $this->productService = $productInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->productService->paginate($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        return $this->productService->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        Gate::authorize('manage-product', $product);

        return $this->productService->find($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        Gate::authorize('manage-product', $product);

        return $this->productService->update($product, $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Gate::authorize('manage-product', $product);

        return $this->productService->delete($product);
    }

    /**
     * Retreive prices history
     */
    public function prices(Request $request, Product $product)
    {
        Gate::authorize('manage-product', $product);

        return $this->productService->prices($request, $product);
    }
}
