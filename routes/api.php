<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TokenGeneratorController;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/', fn() => response()->json(['message' => 'Hello world']));

Route::apiResource('products', ProductController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'show']);
});
Route::get('search', SearchController::class);
Route::post('token/generator', TokenGeneratorController::class);
