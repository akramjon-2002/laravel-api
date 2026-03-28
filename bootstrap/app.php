<?php

use App\Exceptions\ApiResourceNotFoundException;
use App\Http\Middleware\RejectMalformedJson;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prependToGroup('api', RejectMalformedJson::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function (Request $request): bool {
            return $request->is('api/*') || $request->expectsJson();
        });

        $exceptions->render(function (ApiResourceNotFoundException $exception, Request $request): ?JsonResponse {
            if (! $request->is('api/*')) {
                return null;
            }

            return response()->json([
                'message' => $exception->getMessage(),
            ], 404);
        });

        $exceptions->render(function (BadRequestHttpException $exception, Request $request): ?JsonResponse {
            if (! $request->is('api/*')) {
                return null;
            }

            return response()->json([
                'message' => $exception->getMessage() ?: 'Malformed JSON payload.',
            ], 400);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $exception, Request $request): ?JsonResponse {
            if (! $request->is('api/*')) {
                return null;
            }

            $allow = $exception->getHeaders()['Allow'] ?? null;

            return response()->json([
                'message' => $allow
                    ? sprintf('Method not allowed. Supported methods: %s.', $allow)
                    : 'Method not allowed.',
            ], 405);
        });

        $exceptions->render(function (ModelNotFoundException $exception, Request $request): ?JsonResponse {
            if (! $request->is('api/*')) {
                return null;
            }

            $resource = Str::of(class_basename($exception->getModel()))
                ->snake(' ')
                ->replace('_', ' ')
                ->title();

            return response()->json([
                'message' => sprintf('%s not found.', $resource),
            ], 404);
        });

        $exceptions->render(function (NotFoundHttpException $exception, Request $request): ?JsonResponse {
            if (! $request->is('api/*')) {
                return null;
            }

            $previous = $exception->getPrevious();

            if ($previous instanceof ModelNotFoundException) {
                $resource = Str::of(class_basename($previous->getModel()))
                    ->snake(' ')
                    ->replace('_', ' ')
                    ->title();

                return response()->json([
                    'message' => sprintf('%s not found.', $resource),
                ], 404);
            }

            return response()->json([
                'message' => 'API route not found.',
            ], 404);
        });
    })->create();
