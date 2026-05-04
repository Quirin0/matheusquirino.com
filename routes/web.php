<?php

use Illuminate\Support\Facades\Route;

// Home SPA (export Next em public/index.html)
Route::get('/', fn () => response()->file(public_path('index.html')));
