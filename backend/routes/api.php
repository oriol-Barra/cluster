<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProducteElaboratController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\novaEmpresa;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\empresaController;
use App\Http\Controllers\OrderController;








/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/nouProducte', [ProducteElaboratController::class, 'store']);
Route::post('/users', [UserController::class, 'store']);
Route::post('/empreses',[novaEmpresa::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/novaEmpresa', [empresaController::class, 'store'])->middleware('auth:sanctum');
Route::get('/buscarEmpreses', [EmpresaController::class, 'search']);
Route::get('/empresa/{id}', [EmpresaController::class, 'getEmpresa']);
Route::put('/empresa/{id}', [EmpresaController::class, 'update']);
Route::middleware('auth:sanctum')->get('/usuari/detalls', [UserController::class, 'getDetallsUsuari']);
Route::middleware('auth:sanctum')->get('/empresesPerUser', [EmpresaController::class, 'getEmpresesByUser']);
Route::post('/productes-per-empresa', [ProducteElaboratController::class, 'getProductesByEmpresa']);
Route::get('/empreses', [EmpresaController::class, 'getEmpreses']);
Route::get('/productes', [ProducteElaboratController::class, 'getAllProductes']);
Route::post('/checkout',[OrderController::class, 'store'])->middleware('auth:sanctum');
Route::get('/orders',[OrderController::class,'index'])->middleware('auth:sanctum');









