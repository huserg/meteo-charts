<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [\App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('devices', App\Http\Controllers\Device\DeviceController::class)->except(['show']);

    Route::group(['prefix' => 'graphs', 'as' => 'graphs.'], function() {
        Route::get('/', [App\Http\Controllers\Graph\GraphController::class, 'index'])->name('index');
    });

});
