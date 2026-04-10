<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SiteConfigController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rotas públicas
Route::get('/site-config', [SiteConfigController::class, 'index']);
Route::post('/contact', [ContactController::class, 'send']);
Route::apiResource('projects', ProjectController::class);
