<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UploadTestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;
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
 * @group         Auth
 * @authenticated
 */
Route::middleware('auth:sanctum')->get(
    '/user', function (Request $request) {
        $user = $request->user();
        $user->load('roles');

        return response()->json(
            [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'username' => $user->username,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name'),
            ]
        );
    }
);

/**
 * Get the authenticated user with metadata.
 *
 * @group         Auth
 * @authenticated
 */
Route::middleware('auth:sanctum')->get(
    '/me', function (Request $request) {
        $user = $request->user();
        $user->load('roles');

        return response()->json(
            [
            'user_id' => $user?->id,
            'user' => [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'username' => $user->username,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name'),
            ],
            ]
        );
    }
);

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/auth/google', [AuthController::class, 'googleLogin']);
Route::post('/lost-password', [AuthController::class, 'lostPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/check-auth', [AuthController::class, 'checkAuth']);

// Test route
/**
 * Health check.
 *
 * @group Health
 */
Route::get(
    '/hello', function () {
        return 'Hello world from Laravel! This is a test route to check if the API is working.';
    }
);

// Upload test route
Route::post('/upload-test', [UploadTestController::class, 'upload']);

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

// Invoice routes
// - Admin & Vendor: full access
// - Customer: read-only, own invoices only (scoped in controller)
Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('/invoices', [InvoiceController::class, 'index']);
        Route::get('/invoices/{id}', [InvoiceController::class, 'show']);
        Route::get('/invoices/{id}/pdf', [InvoiceController::class, 'pdf']);
        Route::post('/invoices', [InvoiceController::class, 'store'])->middleware('role:admin,vendor');
        Route::put('/invoices/{id}', [InvoiceController::class, 'update'])->middleware('role:admin,vendor');
        Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy'])->middleware('role:admin,vendor');
    }
);


// User routes
Route::get('/users/roles', [UserController::class, 'roles']);
Route::get('/users', [UserController::class, 'index']);
Route::middleware('auth:sanctum')->post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::middleware('auth:sanctum')->put('/users/{id}', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/users/{id}', [UserController::class, 'destroy']);
Route::patch('/users/update-role', [UserController::class, 'updateRole']);

// Visitor routes
Route::post('/visitors/track', [VisitorController::class, 'track']);
Route::get('/visitors/today', [VisitorController::class, 'today']);
Route::get('/visitors/total', [VisitorController::class, 'total']);

