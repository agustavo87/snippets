<?php

use App\Http\Controllers\ComponentController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/components');

Route::get('components', ComponentController::class);
