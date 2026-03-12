<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * Cloud Run warmup endpoint.
 *
 * Cloud Run sends GET /_ah/warmup to a new instance before it receives live
 * traffic. Responding here bootstraps the Laravel+OPcache stack so the first
 * real API request is fast.  Cloud Scheduler also pings this every 5 minutes
 * to keep the running instance hot (see cloudbuild.yaml, Step 3).
 */
Route::get('/_ah/warmup', function () {
    return response()->json(['status' => 'warm'], 200);
});
