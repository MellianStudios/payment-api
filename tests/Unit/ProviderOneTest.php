<?php

namespace Tests\Unit;

use App\Exceptions\PaymentFailedException;
use App\Services\Providers\ProviderOneService;
use PHPUnit\Framework\TestCase;

class ProviderOneTest extends TestCase
{
    public function test_it_throws_error_when_payment_data_is_malformed_or_missing(): void
    {
        $service = new ProviderOneService();

        $this->expectException(PaymentFailedException::class);
        $this->expectExceptionMessage('The \'customer_id\' key is missing from provider data.');

        $service->validateIncomingData([
            'customr_id' => '123',
            'price_id' => '456',
        ]);

        $this->expectException(PaymentFailedException::class);
        $this->expectExceptionMessage('The \'customer_id\' key is missing from provider data.');

        $service->validateIncomingData([
            'price_id' => '456',
        ]);
    }
}
