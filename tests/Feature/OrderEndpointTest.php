<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class OrderEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_and_items_are_created(): void
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $items = [
            [
                'product_id' => 1,
                'price_id' => 1,
                'discount_id' => 1,
            ],
            [
                'product_id' => 1,
                'price_id' => 1,
                'something' => 1,
            ],
        ];

        $this->postJson(route('v1.order'), [
            'user_id' => $user->id,
            'items' => $items,
        ])->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
        ]);

        foreach ($items as $item) {
            if (isset($item['something'])) {
                unset($item['something']);
            }

            $this->assertDatabaseHas('order_items', $item);
        }
    }
}
