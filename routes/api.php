<?php

use App\Http\Controllers\postController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

Route::controller(userController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');
});



Route::controller(postController::class)->group(function(){
    Route::post('create','create');
    Route::get('listing','listing');
    Route::post('edit/{id}','edit');
    Route::post('delete/{id}','delete');
});