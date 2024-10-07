<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(\App\Http\Controllers\WeatherForecastController::class)->group(function () {
    Route::get('/weather-forecasts', 'forecast')->name('weather-forecasts.forecast');
    Route::get('/places', 'searchedPlaces')->name('weather-forecasts.searched-places');
});
