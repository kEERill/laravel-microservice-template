<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Illuminate\Validation\ValidationException as LaravelValidationException;

final class Handler extends ExceptionHandler
{
    /**
     * @var array A list of the exception types that are not reported.
     */
    protected $dontReport = [
        CommandNotFoundException::class
    ];

    /**
     * @var array A list of the inputs that are never flashed for validation exceptions.
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        if ($e instanceof NotFoundHttpException) {
            return response()
                ->json(['message' => $e->getMessage() ?: 'Метод не определен. Пожалуйста, проверьте URL'], $e->getStatusCode());
        }

        return parent::render($request, $e);
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse
    {
        return response()
            ->json(['message' => $exception->getMessage()], 401);
    }

    /**
     * @param Request $request
     * @param LaravelValidationException $exception
     * @return JsonResponse
     */
    protected function invalidJson($request, LaravelValidationException $exception): JsonResponse
    {
        $errors = $exception->errors();
        $message = $exception->validator->errors()->first()
            ?: $exception->getMessage();

        return response()
            ->json(compact('message', 'errors'), $exception->status);
    }
}
