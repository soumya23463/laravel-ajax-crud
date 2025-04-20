<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
Route::get('/', [StateController::class, 'index'])->name('home');
