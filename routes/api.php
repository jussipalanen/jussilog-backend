<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

/**
 * Get the authenticated user.
 *
 * @group Auth
 * @authenticated
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Get the authenticated user with metadata.
 *
 * @group Auth
 * @authenticated
 */
Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    $user = $request->user();

    return response()->json([
        'user_id' => $user?->id,
        'user' => $user,
    ]);
});

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/check-auth', [AuthController::class, 'checkAuth']);

// Test route
/**
 * Health check.
 *
 * @group Health
 */
Route::get('/hello', function () {
    return 'Hello world from Laravel';
});

// Product routes
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

// Order routes
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('/my-orders', [OrderController::class, 'myOrders']);


// User routes
Route::get('/users', [UserController::class, 'index']);
