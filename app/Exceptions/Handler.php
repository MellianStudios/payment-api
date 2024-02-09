<?php

namespace App\Exceptions;

use App\Enums\ResponseStatus;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (PaymentFailedException $e) {
            return Response::json(['status' => ResponseStatus::ERROR, 'message' => $e->getMessage()], 400);
        });
    }
}
