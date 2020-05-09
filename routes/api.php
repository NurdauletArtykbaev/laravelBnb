<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Bookable;
use App\Api\BookableAvailabityController;

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

// Route::get('bookables', function (Request $request) {
//     return Bookable::all();
// });

// Route::get('bookable/{id}', function (Request $request, $id) {
// //optional бар болса соны алады жок болса по умолчанию null или тб значения беруге болады
// // Route::get('bookables/{id}/{optional?}', function (Request $request, $id, $optional = null) {
//     // dd($id, $optional);
//     return Bookable::findOrFail($id);
// });

// Route::get('bookables', 'Api\BookableController@index');
// Route::get('bookable/{id}', 'Api\BookableController@show');
Route::apiResource('bookables', 'Api\BookableController')->only(['index', 'show']);
Route::get('bookables/{bookable}/availability', 'Api\BookableAvailabilityController')
       ->name('bookables.availabity.show');
Route::get('bookables/{bookable}/reviews', 'Api\BookableReviewController')->name('bookables.reviews.index');
Route::apiResource('reviews', 'Api\ReviewController')->only(['show', 'store']);
Route::get('/booking-by-review/{reviewKey}', 'Api\BookingByReviewController')->name('booking.by-review.show');