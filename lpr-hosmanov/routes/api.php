<?php

use App\Http\Controllers\Api\FlightController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn () => response()->json([
    'message' => 'pong',
    'time' => now()->toIso8601String(),
    'student' => config('lab.slug'),
]));

Route::name('api.')->group(function () {
    Route::apiResource('flights', FlightController::class);
});