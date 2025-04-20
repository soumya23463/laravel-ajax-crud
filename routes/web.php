<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
Route::get('/', [StateController::class, 'index'])->name('home');

Route::post('/addCity', [CityController::class, 'store'])->name('city.store');
Route::get('/getCity', [CityController::class, 'index'])->name('city.index');
Route::post('/editCity', [CityController::class, 'edit'])->name('city.edit');
Route::post('/updateCity', [CityController::class, 'update'])->name('city.update');
Route::post('/deleteCity', [CityController::class, 'destroy'])->name('city.destroy');
