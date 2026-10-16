<?php

use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('catalog.index'));

Route::prefix('catalog')
    ->name('catalog.')
    ->controller(CatalogController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');

        Route::get('/airport/{airport?}', 'byAirport')
            ->name('airport');

        Route::get('/code/{code}', 'byCode')
            ->where('code', '[A-Z]{2}-[0-9]{4}')
            ->name('code');

        Route::get('/{id}', 'show')
            ->whereNumber('id')
            ->name('show');
    });

Route::get('/hello/{name?}', function (string $name = 'гость') {
    return "Привет, {$name}!";
})->where('name', '\p{L}+');