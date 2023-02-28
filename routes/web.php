<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopupController;

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

Route::get('/', [TopupController::class, 'index'])->name('topup.index');
Route::get('/process-top-topup-users', [TopupController::class, 'processTopTopupUsers'])->name('topup.process');
