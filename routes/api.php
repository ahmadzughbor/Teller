<?php

use App\Http\Controllers\api\processesController;
use App\Http\Controllers\Auth\LoginController;
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

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::middleware('auth:api')->group( function (Request $request) {
    
    
    
    
    
// });
Route::post('/login', [LoginController::class ,'apiLogin']);
Route::post('/logout',[LoginController::class ,'apiLogout'] );
Route::post('/refresh', [LoginController::class ,'apiRefresh']);
Route::get('/data', [processesController::class ,'data']);