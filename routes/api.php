<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
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
Route::resource('products', ProductController::class);

// public routes
route::post('/register', [AuthController::class, 'register']);
route::post('/login', [AuthController::class, 'login']);
route::get('/products',[ProductController::class, 'index']);
route::get('/products/{id}',[ProductController::class, 'show']);
Route::get('/products/search/{name}', [ProductController::class,'search']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    route::post('/products', [ProductController::class, 'store']);
    route::put('/products/{id}', [ProductController::class, 'update']);
    route::delete('/products/{id}', [ProductController::class, 'destroy']);
    route::post('/logout', [AuthController::class, 'logout']);
});





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 