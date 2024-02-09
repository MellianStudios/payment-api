<?php

namespace App\Services\Providers;

use App\Enums\PaymentProvider;
use App\Enums\TransactionStatus;
use App\Exceptions\PaymentFailedException;
use App\Models\Order;
use App\Services\PaymentContract;

class ProviderOneService implements PaymentContract
{
    public function pay(array $data, int $order_id): void
    {
        $this->validateIncomingData($data);

        $order = Order::where('id', $order_id)->first();

        if (!$order) {
            throw new PaymentFailedException('Order does not exist');
        }

        $transaction = $order->transactions()->create([
            'provider' => PaymentProvider::PROVIDER_ONE,
            'status' => TransactionStatus::PENDING,
        ]);

        // api communication with provider

        // if payment fails
//        if () {
//            $transaction->update([
//                'status' => TransactionStatus::FAILED,
//            ]);
//
//            return;
//        }

        $transaction->update([
            'status' => TransactionStatus::SUCCESS,
        ]);
    }

    public function validateIncomingData(array $data): void
    {
        $required = ['customer_id', 'price_id'];

        foreach ($required as $item) {
            if (!isset($data[$item])) {
                throw new PaymentFailedException("The '$item' key is missing from provider data.");
            }
        }
    }
}
