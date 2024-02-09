<?php

namespace App\Services;

use App\Enums\PaymentProvider;
use App\Services\Providers\ProviderOneService;
use App\Services\Providers\ProviderTwoService;

class PaymentService
{
    private PaymentContract $provider;

    public function setProvider(PaymentProvider $provider): self
    {
        switch ($provider) {
            case PaymentProvider::PROVIDER_ONE:
                $this->provider = new ProviderOneService();

                break;
            case PaymentProvider::PROVIDER_TWO:
                $this->provider = new ProviderTwoService();

                break;
        }

        return $this;
    }

    public function pay(array $provider_data, int $order_id): void
    {
        $this->provider->pay($provider_data, $order_id);
    }
}
