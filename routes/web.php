<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagamentoController;
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
    return view('pagamento');
})->name("index");
Route::get('/boleto', [PagamentoController::class, "boleto"])->name("boleto");
Route::post('/boleto', [PagamentoController::class, "boletoPay"]);
Route::get('/pagamento', [PagamentoController::class, "index"])->name("cartao");
Route::post('/pagamento', [PagamentoController::class, "store"])->name("store-form");

Route::get('/success', function () {
    return "<h3>Pagamento Aprovado!</h3>";
});

Route::get('/error', function () {
    return "<h3>Ops! Seu pagamento não foi realizado!</h3>";
});
