<?php

use Illuminate\Support\Facades\Route;

// Página inicial = export estático do Next (sem redirect para /frontend na barra de endereço)
Route::get('/', fn () => response()->file(public_path('frontend/index.html')));

// Serve a página inicial do frontend
Route::get('/frontend', fn () => response()->file(public_path('frontend/index.html')));

// Serve qualquer rota/arquivo do frontend estático
Route::get('/frontend/{path}', function (string $path) {
    $file = public_path("frontend/{$path}");

    if (is_file($file)) {
        return response()->file($file);
    }

    $index = public_path("frontend/{$path}/index.html");
    if (is_file($index)) {
        return response()->file($index);
    }

    $page404 = public_path('frontend/404.html');
    if (is_file($page404)) {
        return response()->file($page404)->setStatusCode(404);
    }

    abort(404);
})->where('path', '.*');

// Fallback: assets do Next.js (imagens, ícones, fontes) que são referenciados
// sem o prefixo /frontend pelo HTML gerado na exportação estática
Route::get('/{path}', function (string $path) {
    $file = public_path("frontend/{$path}");

    if (is_file($file)) {
        return response()->file($file);
    }

    abort(404);
})->where('path', '^(?!api|frontend|sanctum).*');
