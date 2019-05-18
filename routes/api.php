<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::group(['prefix' => '1.0'], function () {
    /**
     * Rutas para tren
     */
    Route::group(['prefix' => 'train'],function(){
        Route::resource('zones', 'AvailableZoneController',[
            'index'
        ]);
        Route::resource('search', 'AvailableTrips',[
            'index', 'show'
        ]);
        Route::resource('reservations', 'ReservationsController',[
            'store', 'show'
        ]);
    });

    /**
     * Rutas para  hotel
     */
    Route::group(['prefix' => 'hotel'],function(){
        Route::resource('zones', 'HotelZone',[
            'index'
        ]);
        Route::resource('search', 'HotelSearch',[
            'index', 'show'
        ]);
        Route::resource('reservations', 'HotelReservation',[
            'store', 'show'
        ]);
    });
});
