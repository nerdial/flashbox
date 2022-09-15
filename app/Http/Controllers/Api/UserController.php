<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function response;

class UserController extends Controller
{

    public function currentUser(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'data' => [
                'name' => $user->name,
                'role' => $user->getRoleNames()->first()
            ]
        ]);
    }


}
