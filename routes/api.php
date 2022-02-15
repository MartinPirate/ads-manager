<?php

use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\AdsManagerController;

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], static function () {
    /*   Route::group(['middleware' => ['auth:api']], static function () {*/

    Route::get('providers', [ProviderController::class, 'index']);
    Route::get('files/{media_type?}/{date_created?}', [AdsManagerController::class, 'loadAllFiles']);
    Route::post('upload-image', [AdsManagerController::class, 'uploadImageAndAudiFiles']);
    Route::post('upload-video', [AdsManagerController::class, 'uploadVideo']);

    /*    });*/

});
