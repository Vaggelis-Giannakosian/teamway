<?php

use App\Http\Controllers\TestsController;
use App\Models\Test;
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

Route::get('/', function () {
    $tests = Test::all();
    return view('home', compact('tests'));
})->name('home');

Route::prefix('{test:slug}')->name('tests.')->group(function () {
    Route::get('/', [TestsController::class, 'show'])->name('show');
    Route::put('/', [TestsController::class, 'complete'])->name('complete');
    Route::get('/result', [TestsController::class, 'result'])->name('result');
});



