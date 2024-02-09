<?php

namespace App\Services\Providers;

use App\Enums\PaymentProvider;
use App\Enums\TransactionStatus;
use App\Exceptions\PaymentFailedException;
use App\Models\Order;
use App\Services\PaymentContract;

class ProviderTwoService implements PaymentContract
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
        // always fail for sake of testing
        if (true) {
            $transaction->update([
                'status' => TransactionStatus::FAILED,
            ]);

            throw new PaymentFailedException('Transaction failed');
        }

        $transaction->update([
            'status' => TransactionStatus::SUCCESS,
        ]);
    }

    public function validateIncomingData(array $data): void
    {
        $required = ['card_token', 'price', 'currency'];

        foreach ($required as $item) {
            if (!isset($data[$item])) {
                throw new PaymentFailedException("The '$item' key is missing from provider data.");
            }
        }
    }
}
