<?php

namespace App\Exceptions;

use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            return response()->json(['error' => 'Unauthorized access - Token required or invalid'], 401);
        }
         // Check if the exception is an instance of ModelNotFoundException
            if ($exception instanceof ModelNotFoundException) {

                return response()->json([
                    // 'data' is set to null because the requested resource was not found
                    'data' => null,
                    'message' => 'Not found',
                ], 404);
            }
            // if ($exception instanceof HttpException) {
            //     return response()->json([
            //         'message' => 'You are not authorized to do this action.'
            //     ], $exception->getStatusCode());
            // }
        if ($exception instanceof TokenExpiredException) {
            return response()->json(['error' => 'Token has expired'], 401);
        } elseif ($exception instanceof TokenInvalidException) {
            return response()->json(['error' => 'Invalid token'], 401);
        } elseif ($exception instanceof JWTException) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        return parent::render($request, $exception);
    }
}
