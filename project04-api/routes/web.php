<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Poly\Analyzing\Analyzor;
use App\Http\Controllers\Poly\Operation\PolyOperation;
use App\Http\Controllers\Poly\Types\Poly;

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

Route::get('t', function () {
    return 'web.php';
})->middleware('auth');