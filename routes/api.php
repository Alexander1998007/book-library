<?php

use App\Http\Controllers\BookController;
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

Route::middleware('api.token')->
prefix('book')->
controller(BookController::class)->
group(function () {
    // Отримати список всіх книг
    Route::get('/', 'index'); // GET /book
    // Отримати одну книгу за ID
    Route::get('/{id}', 'show'); // GET /book/{id}
    // Додати нову книгу
    Route::post('/', 'store'); // POST /book
    // Оновити інформацію про книгу за ID
    Route::patch('/{id}', 'update'); // PATCH /book/{id}
    // Видалити книгу за ID
    Route::delete('/{id}', 'destroy'); // DELETE /book/{id}
});
