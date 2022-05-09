<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::group(['prefix' => 'auth'] , function (){
        Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register'])
        ->withoutMiddleware('auth:sanctum');

        Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login'])
        ->withoutMiddleware('auth:sanctum');
        Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class , 'logout']);

    });

    Route::get('/me', function(Request $request) {
        return auth()->user();
    });

    Route::post('/product-create' , \App\Http\Controllers\Api\ProductController::class);
    Route::post('/store-create' , \App\Http\Controllers\Api\StoreController::class );
    Route::post('/center-create' , \App\Http\Controllers\Api\CenterController::class );
    Route::post('/send-volunteer-request' , \App\Http\Controllers\Api\UserVolunteerRequestController::class);
    Route::post('/volunteer-change-status-request' , \App\Http\Controllers\Api\VolunteerAcceptRequestController::class);
    Route::get('/get-volunteers' , \App\Http\Controllers\Api\FetchVolunteersController::class );
    Route::post('/add-phone-number' , \App\Http\Controllers\Api\CenterStorePhoneController::class );
    Route::post('/approve-center' , \App\Http\Controllers\Api\ApproveCenter::class );
    Route::post('/approve-store' , \App\Http\Controllers\Api\ApproveStore::class );
    Route::post('/center-evaluation' , \App\Http\Controllers\Api\CenterEvaluationController::class );
    Route::get('/get-centers' , \App\Http\Controllers\Api\GetCentersController::class );
    Route::post('/center-booking' , \App\Http\Controllers\Api\CenterBookingController::class);
    Route::post('/add-store-product' , \App\Http\Controllers\Api\AddStoreProductController::class);
    Route::post('/create-admin' , \App\Http\Controllers\Api\CreateAdminController::class);
    Route::post('/end-volunteering' , \App\Http\Controllers\Api\VolunteerEndVolunteering::class);



});
