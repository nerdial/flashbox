<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSellerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'shopTitle' => 'required|string',
            'address' => 'required|string',
            'email'   => 'required|email|unique:users',
            'password'  => 'required|min:6',
            'lng'  => 'required|numeric|min:1',
            'lat'  => 'required|numeric|min:1',
        ];
    }
}
