<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public function create(int $user_id, array $items): Order
    {
        $order = Order::create([
            'user_id' => $user_id,
        ]);

        $order->items()->createMany($items);

        return $order;
    }
}
