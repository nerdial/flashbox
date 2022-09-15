<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function __construct(private CustomerService $customerService)
    {
    }

    public function getNearbyProducts(Request $request)
    {
        $user = $request->user();
        $products = $this->customerService->findNearbyProducts($user);
        return ProductResource::collection($products);
    }

    public function purchaseAnItem(Product $product, Request $request)
    {
        $user = $request->user();
        $this->customerService->purchaseAnItem($product, $user);

        return response()->json([
            'success' => true
        ]);
    }


}
