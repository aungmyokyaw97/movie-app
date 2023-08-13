<?php

use App\Http\Controllers\API\v1\AuthControlller;
use App\Http\Controllers\API\v1\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::prefix('v1/asd3k23asdfmdsfwefjadfnak3345632cvnwef')->group(function(){

    Route::controller(AuthControlller::class)->middleware('throttle:api-auth')->group(function(){
        Route::post('login','login');
        Route::post('register','register');
    });


    Route::middleware('auth:sanctum')->group(function(){
        
        Route::controller(MovieController::class)->prefix('movie')->group(function(){
            Route::get('my/list','index');
            Route::post('create','create');        
            Route::post('edit','edit');
            Route::post('delete','destroy');
        });

    });

    Route::controller(MovieController::class)->prefix('movie')->group(function(){ 
        Route::post('review/create','movieReview');
        Route::post('detail','detail');
        Route::post('list','list');
        Route::post('export','export')->middleware('throttle:api-download');
        Route::get('download/export','download')->name('download-csv')->middleware('throttle:api-download');
    });

    

// });
