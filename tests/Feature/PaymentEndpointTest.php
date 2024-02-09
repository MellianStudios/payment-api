<?php

namespace Tests\Feature;

use App\Enums\ResponseStatus;
use App\Enums\TransactionStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PaymentEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_process_with_provider_one_works(): void
    {
        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => 1,
        ]);

        Passport::actingAs($user);

        $items = [
            [
                'product_id' => 1,
                'price_id' => 1,
            ],
        ];

        $this->postJson(route('v1.order'), [
            'user_id' => 1,
            'items' => $items,
        ])->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'user_id' => 1,
        ]);

        foreach ($items as $item) {
            $this->assertDatabaseHas('order_items', $item);
        }

        $this->postJson(route('v1.payment'), [
            'provider' => 'PROVIDER_ONE',
            'provider_data' => [
                'customer_id' => 'abc',
                'price_id' => 'xyz',
            ],
            'order_id' => $order->id,
        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => ResponseStatus::SUCCESS->value,
            ]);

        $this->assertDatabaseHas('order_transactions', [
            'order_id' => $order->id,
            'status' => TransactionStatus::SUCCESS,
        ]);
    }

    public function test_payment_process_with_provider_two_fails(): void
    {
        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => 1,
        ]);

        Passport::actingAs($user);

        $items = [
            [
                'product_id' => 1,
                'price_id' => 1,
            ],
        ];

        $this->postJson(route('v1.order'), [
            'user_id' => 1,
            'items' => $items,
        ])->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'user_id' => 1,
        ]);

        foreach ($items as $item) {
            $this->assertDatabaseHas('order_items', $item);
        }

        $this->postJson(route('v1.payment'), [
            'provider' => 'PROVIDER_TWO',
            'provider_data' => [
                'card_token' => 'abc',
                'price' => 10,
                'currency' => 'eur',
            ],
            'order_id' => $order->id,
        ])
            ->assertStatus(400)
            ->assertJson([
                'status' => ResponseStatus::ERROR->value,
                'message' => 'Transaction failed',
            ]);

        $this->assertDatabaseHas('order_transactions', [
            'order_id' => $order->id,
            'status' => TransactionStatus::FAILED,
        ]);
    }
}
