<?php

use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile.index');
Route::middleware(['auth', 'verified'])->post('/update', [ProfileController::class, 'update'])
    ->name('profile.update');
Route::post('/change-password', [ProfileController::class, 'changePassword'])
    ->name('change.password');

