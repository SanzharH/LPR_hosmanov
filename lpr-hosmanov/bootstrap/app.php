<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Support\ApiFormat;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
        $exceptions->render(function (
    ValidationException $e,
    Request $request
) {
    if ($request->is('api/*')) {
        return ApiFormat::error(
            'Ошибка валидации данных',
            422,
            $e->errors()
        );
    }
});

$exceptions->render(function (
    HttpException $e,
    Request $request
) {
    if ($request->is('api/*')) {
        $message = match ($e->getStatusCode()) {
            404 => 'Ресурс не найден',
            405 => 'Метод не поддерживается для этого адреса',
            default => $e->getMessage() ?: 'Ошибка HTTP',
        };

        return ApiFormat::error($message, $e->getStatusCode());
    }
});
    })->create();
