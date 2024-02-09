<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'numeric',
                'integer',
            ],
            'items' => [
                'required',
                'array',
            ],
            'items.*' => [
                'required',
                'array',
            ],
            'items.*.product_id' => [
                'required',
                'numeric',
                'integer',
                // check if exists in DB
            ],
            'items.*.price_id' => [
                'required',
                'numeric',
                'integer',
                // check if exists in DB
            ],
            'items.*.discount_id' => [
                'nullable',
                'numeric',
                'integer',
                // check if exists in DB if not null
            ],
        ];
    }
}
