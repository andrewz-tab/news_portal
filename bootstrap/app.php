<?php

use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
//        $middleware->validateCsrfTokens(except: [
//            '*',
//        ]);
        $middleware->alias([
            'check.ban' => \App\Http\Middleware\CheckBanMiddleware::class,
            'ban.page' => \App\Http\Middleware\BanPageMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'author' => \App\Http\Middleware\AuthorMiddleware::class,
        ]);
    })->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();