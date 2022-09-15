<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSellerRequest;
use App\Http\Resources\SellerResource;
use App\Models\User;
use App\Repositories\SellerRepository;

class AdminController extends Controller
{

    public function sellerList()
    {
        $sellers = User::role('seller')->limit(10)->get()->load('shop');
        return SellerResource::collection($sellers);
    }

    public function storeNewSeller(
        StoreSellerRequest $request,
        SellerRepository   $repository
    )
    {
        $data = $request->validated();
        $repository->createNewSeller($data);

        return response()->json([
            'success' => true
        ], 201);
    }
}
