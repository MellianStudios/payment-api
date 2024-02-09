<?php

namespace App\Services;

interface PaymentContract
{
    public function pay(array $data, int $order_id): void;

    public function validateIncomingData(array $data): void;
}
