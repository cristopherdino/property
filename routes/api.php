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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('properties', 'PropertyController@index');
Route::get('property/{propertyID}', 'PropertyController@show');
Route::post('property', 'PropertyController@store');

// I did this because google map api service is not free
// and i don't have credit card to even register for trial. Sorry about this. peace! :)
Route::get('google_map_mocking', function () {
    return response()->json([
        "result" => [
            "address_components" => [
                [
                    "long_name" => "Amsterdam",
                    "short_name" => "Amsterdam",
                    "types" => ["locality", "political"]
                ],
                [
                    "long_name" => "Government of Amsterdam",
                    "short_name" => "Government of Amsterdam",
                    "types" => ["administrative_area_level_2", "political"]
                ],
                [
                    "long_name" => "North Holland",
                    "short_name" => "NH",
                    "types" => ["administrative_area_level_1", "political"]
                ],
                [
                    "long_name" => "Netherlands",
                    "short_name" => "NL",
                    "types" => ["country", "political"]
                ],
                [
                   "long_name" => "94043",
                   "short_name" => "94043",
                   "types" => [ "postal_code" ]
                ]
            ],
            "formatted_address" => "Winnetka, IL, USA",
            "geometry" => [
                "bounds" => [
                    "northeast" => [
                        "lat" => 42.1282269,
                        "lng" => -87.7108162
                    ],
                    "southwest" => [
                        "lat" => 42.0886089,
                        "lng" => -87.7708629
                    ]
                ],
                "location" => [
                    "lat" => 42.10808340000001,
                    "lng" => -87.735895
                ],
                "location_type" => "APPROXIMATE",
                "viewport" => [
                    "northeast" => [
                        "lat" => 42.1282269,
                        "lng" => -87.7108162
                    ],
                    "southwest" => [
                        "lat" => 42.0886089,
                        "lng" => -87.7708629
                    ]
                ]
            ],
            "place_id" => "ChIJW8Va5TnED4gRY91Ng47qy3Q",
            "types" => ["locality", "political"]
        ]
    ]);
});
