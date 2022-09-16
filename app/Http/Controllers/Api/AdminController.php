<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSellerRequest;
use App\Http\Resources\SellerResource;
use App\Repositories\SellerRepository;

class AdminController extends Controller
{

    public function __construct(
        private SellerRepository $sellerRepository
    )
    {
    }

    public function sellerList(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $sellers = $this->sellerRepository->getAllSellers();
        return SellerResource::collection($sellers);
    }

    public function storeNewSeller(StoreSellerRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $this->sellerRepository->createNewSeller($data);

        return response()->json([
            'success' => true
        ], 201);
    }
}
