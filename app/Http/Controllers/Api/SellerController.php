<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class SellerController extends Controller
{

    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function getAllProducts(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $products = $this->productRepository->getSellerProducts($request->user());
        return ProductResource::collection($products);
    }

    public function storeProduct(StoreProductRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->productRepository->createNewProduct($request->validated(), $request->user());
        return response()->json([
            'status' => true
        ], 201);
    }
}
