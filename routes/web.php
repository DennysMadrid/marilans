<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PriceCalculatorController;

Route::get('/', function () {
    return view('pages.home');
});

//Route::post('/calculate-amazon-price', [AmazonPriceController::class, 'calculatePrice'])->name('amazon.price');
//Route::get('/price-calculator', [PriceCalculatorController::class, 'showForm'])->name('price.form');
Route::post('/calculate-price', [PriceCalculatorController::class, 'calculatePrice'])->name('calculate.price');
