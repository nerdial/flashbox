<?php

namespace App\Services;

use App\Contracts\Gateway;

class PaypalGateway implements Gateway
{
    public function pay() :array
    {
        // gateway data
        return [
            'tracking_number' => '123456'
        ];
    }
}
