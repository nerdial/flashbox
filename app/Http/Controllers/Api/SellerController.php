<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function getAllProducts(Request $request)
    {
        $shop = $request->user()->shop;
        return ProductResource::collection($shop->products);
    }

    public function storeProduct(StoreProductRequest $request, ProductRepository $repository)
    {
        $repository->createNewProduct($request->validated(), $request->user());
        return response()->json([
            'status' => true
        ], 201);
    }
}
