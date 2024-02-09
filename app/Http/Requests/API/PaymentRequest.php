<?php

namespace App\Http\Requests\API;

use App\Enums\PaymentProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'provider' => [
                'required',
                'string',
                Rule::in(PaymentProvider::values()),
            ],
            'provider_data' => [
                'required',
                'array',
            ],
            'order_id' => [
                'required',
                'numeric',
                'integer',
                'exists:orders,id',
            ],
        ];
    }
}
