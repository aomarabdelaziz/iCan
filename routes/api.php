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


Route::group(['middleware' => [ 'auth:sanctum']], function () {

    //////////////////////////////////////////// Auth Routes //////////////////////////////////////////////////////////
    Route::group(['prefix' => 'auth' , 'controller' => \App\Http\Controllers\Api\AuthController::class] , function (){

        Route::post('/register', 'register')->withoutMiddleware('auth:sanctum');
        Route::post('/login', 'login')->withoutMiddleware('auth:sanctum');
        Route::post('/logout',  'logout');
        Route::get('/get-user-data-by-token',  'getUserDataByToken');
        Route::post('/change-password',  'changePassword');

    });
    //////////////////////////////////////////// Auth Routes //////////////////////////////////////////////////////////

    //////////////////////////////////////////// Center Routes //////////////////////////////////////////////////////////
    Route::group(['prefix' => 'center' , 'middleware' => 'checkCenterRole'] , function (){

        Route::get('/get-centers' , \App\Http\Controllers\Api\GetCentersController::class )->withoutMiddleware('checkCenterRole');
        Route::post('/center-booking' , \App\Http\Controllers\Api\CenterBookingController::class)->withoutMiddleware('checkCenterRole');
        Route::post('/approve-center' , \App\Http\Controllers\Api\ApproveCenter::class )->withoutMiddleware('checkCenterRole');
        Route::post('/center-evaluation' , \App\Http\Controllers\Api\CenterEvaluationController::class )->withoutMiddleware('checkCenterRole');
        Route::post('/create-center' , \App\Http\Controllers\Api\CenterController::class );
        Route::get('/get-user-centers' , \App\Http\Controllers\Api\GetUserCenters::class );

    });
    //////////////////////////////////////////// Center Routes //////////////////////////////////////////////////////////

    //////////////////////////////////////////// Store Routes //////////////////////////////////////////////////////////
    Route::group(['prefix' =>'store' , 'middleware' => 'checkStoreRole'] , function (){
        Route::post('/create-store' , \App\Http\Controllers\Api\StoreController::class );
        Route::get('/get-all-stores' , \App\Http\Controllers\Api\GetStoresController::class )->withoutMiddleware('checkStoreRole');
    });
    //////////////////////////////////////////// Store Routes //////////////////////////////////////////////////////////



    //////////////////////////////////////////// Product Routes //////////////////////////////////////////////////////////
    Route::group(['prefix' =>'product' ] , function (){

        Route::get('/get-products' , \App\Http\Controllers\Api\GetStoreProducts::class);
        Route::post('/add-store-product' , \App\Http\Controllers\Api\AddStoreProductController::class);
        Route::post('/product-create' , [\App\Http\Controllers\Api\ProductController::class , 'create']);
        Route::delete('/product-delete', [\App\Http\Controllers\Api\ProductController::class , 'delete']);
        Route::put('/product-update', [\App\Http\Controllers\Api\ProductController::class , 'updatePrice']);

    });
    //////////////////////////////////////////// Product Routes //////////////////////////////////////////////////////////










    Route::get('/get-my-token',  \App\Http\Controllers\Api\GetAuthUserToken::class)->withoutMiddleware('auth:sanctum');
    Route::get('/me' , fn(Request $request) => $request->user());


    Route::post('/send-volunteer-request' , \App\Http\Controllers\Api\UserVolunteerRequestController::class);
    Route::post('/volunteer-change-status-request' , \App\Http\Controllers\Api\VolunteerAcceptRequestController::class);
    Route::get('/get-volunteers' , \App\Http\Controllers\Api\FetchVolunteersController::class );
   // Route::post('/add-phone-number' , \App\Http\Controllers\Api\CenterStorePhoneController::class );
    Route::post('/approve-store' , \App\Http\Controllers\Api\ApproveStore::class );
    Route::post('/create-admin' , \App\Http\Controllers\Api\CreateAdminController::class);
    Route::post('/end-volunteering' , \App\Http\Controllers\Api\VolunteerEndVolunteering::class);



    Route::get('/get-volunteer-trip-data' , \App\Http\Controllers\Api\GetVolunteersTripData::class );

    Route::post('/send-notification-now',[\App\Http\Controllers\Api\SendNotification::class,'now'])->name('notification-now');
    Route::patch('/update-token' , [\App\Http\Controllers\Api\UpdateFCMTokenController::class , 'updateToken'])->name('fcmToken');
    Route::post('/send-notification',[\App\Http\Controllers\Api\SendNotification::class,'notification'])->name('notification');





    //end api route
});
