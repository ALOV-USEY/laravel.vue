<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Hotel;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json(['user' => $request->user()]);
});
Route::get('/hotels', [HotelController::class, 'index']); // Получить все отели с пагинацией
Route::get('/hotels/search', [HotelController::class, 'search']); // Поиск отелей
Route::get('/hotels/{id}', [HotelController::class, 'show']); // Получить отель по ID
Route::post('/hotels', [HotelController::class, 'store']); // Добавить новый отель
Route::put('/hotels/{id}', [HotelController::class, 'update']); // Обновить отель
Route::delete('/hotels/{id}', [HotelController::class, 'destroy']); // Удалить отель
Route::get('/messages', [ChatController::class, 'messages']);
Route::get('/users', [ChatController::class, 'getAllUsers']);
Route::post('/send', [ChatController::class, 'send']);
Route::post('/support-login', [SupportController::class, 'login']);
Route::get('/unique-locations', [HotelController::class, 'getUniqueLocations']);
Route::get('/admin-status', [SupportController::class, 'checkAdminStatus']); // Новый маршрут
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);

//Route::post('/hotels', [HotelController::class, 'store'])->middleware('auth:sanctum');
//Route::put('/hotels/{id}', [HotelController::class, 'update'])->middleware('auth:sanctum');
//Route::delete('/hotels/{id}', [HotelController::class, 'destroy'])->middleware('auth:sanctum');