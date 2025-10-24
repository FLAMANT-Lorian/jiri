<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\JiriController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jiris', [JiriController::class, 'index'])->name('jiris.index')->middleware('auth');
Route::get('/jiris/create', [JiriController::class, 'create'])->name('jiris.create')->middleware('auth');
Route::post('/jiris', [JiriController::class, 'store'])->name('jiris.store')->middleware('auth');
Route::get('/jiris/{jiri}', [JiriController::class, 'show'])->name('jiris.show')->middleware('auth');
Route::get('/jiris/{jiri}/edit', [JiriController::class, 'edit'])->name('jiris.edit')->middleware('auth');
Route::patch('/jiris/{jiri}', [JiriController::class, 'update'])->name('jiris.update')->middleware('auth');


Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index')->middleware('auth');
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create')->middleware('auth');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store')->middleware('auth');
Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show')->middleware('auth');
Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit')->middleware('auth');
Route::patch('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update')->middleware('auth');


Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
