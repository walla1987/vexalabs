<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->expectsJson()) {
                switch ($e) {
                    case $e instanceof ValidationException:
                        $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                        $message = $e->validator->errors()->first();
                        break;
                    case $e instanceof NotFoundHttpException:
                    case $e instanceof HttpException:
                        $message = $e->getMessage();
                        $statusCode = $e->getStatusCode();
                        break;
                    default:
                        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                        $message = 'Server Error.';
                }
                return response()->json(['error' => $message], $statusCode);
            }
        });
    }
}
