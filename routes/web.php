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

Route::get('/', function () {
    return view('welcome');
});

Use App\Http\Controllers\OperadoraController;
Route::prefix('operadoras/')->group(function () {
    Route::get('',[OperadoraController::class,'index'])->name('operadora.index');
    Route::post('',[OperadoraController::class,'store'])->name('operadora.store');
    Route::get('/{operadora}',[OperadoraController::class,'show'])->name('operadora.show');
    Route::put('/{operadora}',[OperadoraController::class,'update'])->name('operadora.update');
    Route::delete('/{operadora}',[OperadoraController::class,'destroy'])->name('operadora.destroy');

});

Route::get('/token', function (Request $request) {
    $token = csrf_token();
    return $token;
});



