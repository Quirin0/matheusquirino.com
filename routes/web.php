<?php

use Illuminate\Support\Facades\File;
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

/*
| Detalhe de projeto: HTML estático existe só para slugs gerados no último build.
| Slug novo (Filament) → serve catch-shell.html; o cliente lê o slug na URL e chama a API.
*/
Route::get('/projetos/{slug}', function (string $slug) {
    $slug = basename($slug);
    $htmlPath = public_path("projetos/{$slug}.html");

    if (File::isFile($htmlPath)) {
        return response()->file($htmlPath);
    }

    $shell = public_path('projetos/catch-shell.html');
    if (File::isFile($shell)) {
        return response()->file($shell);
    }

    abort(404);
})->where('slug', '[^/]+');
