<?php

namespace Tests\Unit;

use App\Exceptions\PaymentFailedException;
use App\Services\Providers\ProviderTwoService;
use PHPUnit\Framework\TestCase;

class ProviderTwoTest extends TestCase
{
    public function test_it_throws_error_when_payment_data_is_malformed_or_missing(): void
    {
        $service = new ProviderTwoService();

        $this->expectException(PaymentFailedException::class);
        $this->expectExceptionMessage('The \'currency\' key is missing from provider data.');

        $service->validateIncomingData([
            'card_token' => 'abc',
            'price' => 10,
            'curency' => 'eur',
        ]);

        $this->expectException(PaymentFailedException::class);
        $this->expectExceptionMessage('The \'currency\' key is missing from provider data.');

        $service->validateIncomingData([
            'card_token' => 'abc',
            'price' => 10,
        ]);
    }
}
