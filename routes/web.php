<?php

use App\Http\Controllers\ComponentController;
use App\Http\Controllers\PathController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/components');

Route::get('components', ComponentController::class)->name('components');

Route::post('/configpath', [PathController::class, 'configure'])->name('path.configure');
