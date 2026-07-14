<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Railway (ve çoğu PaaS) SSL'i kendi proxy katmanında sonlandırıp
        // uygulamaya düz HTTP ile ulaşıyor; X-Forwarded-* başlıklarına
        // güvenmeden Laravel asset/URL linklerini yanlışlıkla http:// üretiyordu.
        $middleware->trustProxies(at: '*', headers: TrustProxies::HEADER_X_FORWARDED_FOR
            | TrustProxies::HEADER_X_FORWARDED_HOST
            | TrustProxies::HEADER_X_FORWARDED_PORT
            | TrustProxies::HEADER_X_FORWARDED_PROTO);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
