<?php

namespace App\Http\Controllers\API;

use App\Enums\PaymentProvider;
use App\Enums\ResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\PaymentRequest;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class PaymentController extends Controller
{
    public function __invoke(PaymentRequest $request, PaymentService $service): JsonResponse
    {
        $service->setProvider(PaymentProvider::from($request->provider))
            ->pay($request->provider_data, $request->order_id);

        return Response::json(['status' => ResponseStatus::SUCCESS]);
    }
}
