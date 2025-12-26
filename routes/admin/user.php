<?php

use App\Http\Controllers\Admin\LaratrustController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user/list', [UserController::class, 'index'])->name('user.list');
Route::get('/getUsers', [UserController::class, 'getUsers'])->name('get.users');
Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
Route::get('/user/suspend/{id}', [UserController::class, 'suspend'])->name('user.suspend');
Route::get('/user/restore/{id}', [UserController::class, 'restore'])->name('user.restore');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

Route::get('/user/get', [UserController::class, 'getUser'])->name('user.get');

Route::get('/roles', [LaratrustController::class, 'roles'])->name('role.index');
Route::post('/role/store', [LaratrustController::class, 'roleStore'])->name('role.store');
Route::get('/role/edit/{id}', [LaratrustController::class, 'roleEdit'])->name('role.edit');
Route::post('/update/role', [LaratrustController::class, 'roelUpdate'])->name('role.update');
Route::get('/role/delete', [LaratrustController::class, 'roleDelete'])->name('role.destroy');

Route::get('/assign/user-role', [LaratrustController::class, 'assignUserRole'])->name('user.assignrole');
Route::post('/assign/role-user', [LaratrustController::class, 'grantUserRole'])->name('user.grantrole');

