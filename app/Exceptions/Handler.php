<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use InvalidArgumentException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (ValidationException $exception, $request) {
            return response()->json([
                'errors' => [
                    'message' => trans('exception.validation'),
                    'errors'  => $exception->errors()
                ]
            ], 422);
        });

        $this->renderable(function (AuthenticationException $exception, $request) {
            return response()->json([
                'errors' => [
                    'message' => trans('exception.unauthorized')
                ]
            ], 401);
        });

        $this->renderable(function (ErrorException $exception, $request) {
            return response()->json([
                'message' => trans($exception->getName(), $exception->getParams()),
                'data' => $exception->getParams()
            ], $exception->getStatusCode());
        });

    }
}
