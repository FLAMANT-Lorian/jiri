<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\JiriController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// À la place d'écrire les 7 routes, il les fait toutes pour nous !
Route::resource('jiris', JiriController::class);

Route::resource('contacts', ContactController::class);

Route::resource('projects', ProjectController::class);
