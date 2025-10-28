<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerSlider;

Route::get('/', function () {
    return view('welcome');
});








Route::resource('sliders', ControllerSlider::class);