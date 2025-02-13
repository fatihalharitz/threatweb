<?php

use App\Http\Controllers\VulnerabilityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/vulnerabilites', [VulnerabilityController::class, 'fetchVulnerabilities']);
