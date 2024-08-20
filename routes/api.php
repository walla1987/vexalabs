<?php

use App\Http\Controllers\CampaignDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;

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

Route::prefix('campaigns')->group(function () {
    Route::post('/', [CampaignController::class, 'create']);
    Route::post('{campaign}/data', [CampaignDataController::class, 'create']);
});




