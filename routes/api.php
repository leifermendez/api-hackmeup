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
        Route::resource('zones', 'AvailableZoneController')
        ->only([
            'index'
        ]);

        Route::resource('search', 'AvailableTrips')
        ->only([
            'index'
        ]);

        Route::resource('reservations', 'ReservationsController')
        ->only([
            'show','store'
        ]);
    });

    /**
     * Rutas para  hotel
     */
    Route::group(['prefix' => 'hotel'],function(){
        Route::resource('zones', 'HotelZone')
        ->only([
            'index'
        ]);
        
        Route::resource('search', 'HotelSearch')
        ->only([
            'show','index'
        ]);
        
        Route::resource('reservations', 'HotelReservation')
        ->only([
            'show','store'
        ]);
    });

    /**
     * Ruta redes sociales
     */

    Route::resource('social-network', 'SocialNetworkController')
    ->only([
        'show','index','update','store'
    ]);
    
});
