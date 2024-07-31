<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AmazonPriceController;

Route::get('/', function () {
    return view('pages.home');
});

Route::post('/calculate-amazon-price', [AmazonPriceController::class, 'calculatePrice'])->name('amazon.price');
