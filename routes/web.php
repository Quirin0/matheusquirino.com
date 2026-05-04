<?php

use Illuminate\Support\Facades\Route;

/*
| Legacy / hospedagem com subpasta: browser pedindo /public/... ou /public/frontend/...
| Redireciona para URLs canônicas sem esse prefixo (evita 403 e links quebrados).
*/
Route::any('/public/{tail}', function (string $tail) {
    $tail = ltrim($tail, '/');

    if ($tail === '' || $tail === 'frontend') {
        return redirect('/', 301);
    }

    if (str_starts_with($tail, 'frontend/')) {
        $tail = substr($tail, strlen('frontend/'));
    }

    return redirect('/'.$tail, 301);
})->where('tail', '.*');

// Home SPA (export Next em public/index.html)
Route::get('/', fn () => response()->file(public_path('index.html')));
