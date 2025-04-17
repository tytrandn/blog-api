<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Helpers\ApiResponse;
use App\Helpers\HttpStatusCode;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        AuthenticationException::class,
        ModelNotFoundException::class,
        NotFoundHttpException::class,
        ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Exception $e) {
            
        });

        $this->renderable(function (ValidationException $e, $request) {
            return ApiResponse::error('Validation failed', HttpStatusCode::UNPROCESSABLE_ENTITY, $e->errors());
        });

        $this->renderable(function (ModelNotFoundException $e, $request) {
            return ApiResponse::error('Resource not found', HttpStatusCode::NOT_FOUND);
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return ApiResponse::error('Route not found', HttpStatusCode::NOT_FOUND);
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            return ApiResponse::error('Unauthenticated', HttpStatusCode::UNAUTHORIZED);
        });

        $this->renderable(function (AuthorizationException $e, $request) {
            return ApiResponse::error('Forbidden', HttpStatusCode::FORBIDDEN);
        });
    }

    /**
     * Convert an exception to an HTTP response.
     *
     * @param  \Exception  $exception
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {

        if (config('app.debug')) {
            return ApiResponse::error($exception->getMessage(), HttpStatusCode::INTERNAL_SERVER_ERROR);
        }

        return ApiResponse::error('Internal Server Error', HttpStatusCode::INTERNAL_SERVER_ERROR);

    }
}
