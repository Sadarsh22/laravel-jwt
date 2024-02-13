<?php

use App\Http\Controllers\commentController;
use App\Http\Controllers\postController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\countryController;
use App\Http\Controllers\stateController;
use App\Http\Controllers\cityController;

Route::controller(userController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');
});

Route::controller(postController::class)->group(function () {
    Route::post('create', 'create');
    Route::post('listing', 'listing');
    Route::patch('edit/{id}', 'edit');
    Route::delete('delete/{id}', 'delete');
    Route::get('view/{id}', 'view');
    Route::post('search', 'search');
});

Route::controller(commentController::class)->group(function () {
    Route::post('createComment/{id}', 'create');
    Route::patch('editComment/{id}', 'edit');
    Route::delete('deleteComment/{id}', 'delete');
});

Route::controller(countryController::class)->group(function () {
    Route::post('country/create', 'create');
    Route::patch('country/update/{id}', 'update');
    Route::get('country/view', 'view');
    Route::post('country/read', 'read');
    Route::delete('country/delete/{id}', 'delete');
});

Route::controller(stateController::class)->group(function () {
    Route::post('state/create/{id}', 'create');
    Route::patch('state/update/{id}', 'update');
    Route::get('state/view', 'view');
    Route::post('state/read', 'read');
    Route::delete('state/delete/{id}', 'delete');
});

Route::controller(cityController::class)->group(function () {
    Route::post('city/create/{id}', 'create');
    Route::patch('city/update/{id}', 'update');
    Route::get('city/view', 'view');
    Route::delete('city/delete/{id}', 'delete');
});
