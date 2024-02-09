<?php

namespace App\Http\Controllers\API;

use App\Enums\ResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\OrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    public function __invoke(OrderRequest $request, OrderService $service): JsonResponse
    {
        $order = $service->create($request->user_id, $request->validated()['items']);

        return Response::json([
            'status' => ResponseStatus::SUCCESS,
            'message' => 'Order created',
            'data' => [
                'order_id' => $order->id,
            ],
        ]);
    }
}
