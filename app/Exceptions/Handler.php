<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

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
        // if (\App::environment('production')){

            $this->renderable(function (ValidationException $exception, $request) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'message' => 'Validation Errors',
                        'status' => false,
                        'code' => 422,
                        'errors' => $exception->validator->errors()->all(),
                        'data' => ""
                    ], 422);
                }
            });

            $this->renderable(function (NotFoundHttpException $exception, $request) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'message' => 'Something wrong',
                        'status' => false,
                        'code' => 404,
                        'errors' => [],
                        'data' => ""
                    ], 404);
                }
            });
            
            $this->renderable(function (AuthenticationException $exception, $request) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'message' => 'Unauthenticated',
                        'status' => false,
                        'code' => 401,
                        'errors' => [],
                        'data' => ""
                    ], 401);
                }
            });

            $this->renderable(function (TooManyRequestsHttpException $exception, $request) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'message' => 'Too Many Attempts',
                        'status' => false,
                        'code' => 429,
                        'errors' => [],
                        'data' => ""
                    ], 429);
                }
            });

            

            $this->renderable(function (AccessDeniedHttpException $exception, $request) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'message' => 'Unauthorized',
                        'status' => false,
                        'code' => 403,
                        'errors' => [],
                        'data' => ""
                    ], 403);
                }
            });

            $this->renderable(function (FatalError $exception, $request) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'message' => 'Server Error',
                        'status' => false,
                        'code' => 500,
                        'errors' => [],
                        'data' => ""
                    ], 500);
                }
            });

        // }
        

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
