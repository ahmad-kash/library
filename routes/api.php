<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RentController;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvbooker within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::controller(BookController::class)->middleware('notFoundIfNotAuth')->group(function () {
    Route::get('books', 'index');
    Route::get('books/{book}/isavailable', 'isAvailable');
    Route::post('books', 'store')->middleware('isAdmin');
    Route::get('books/{book}', 'show');
    Route::delete('books/{book}', 'destroy')->middleware('isAdmin');;
});

Route::controller(RentController::class)->middleware('notFoundIfNotAuth')->group(function () {
    Route::post('books/{book}/registerrent', 'registerBookRentRequest')->middleware('isCustomer');
    Route::delete('books/{book}/users/{user}/removerent', 'removeBookRent')->middleware('isAdmin');
});
Route::controller(PurchaseController::class)->middleware('notFoundIfNotAuth')->group(function () {
    Route::post('books/{book}/registerpurchase', 'registerBookPurchaseRequest')->middleware('isCustomer');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->middleware('guest');
    Route::post('register', 'register')->middleware('guest');
    Route::post('logout', 'logout')->middleware('notFoundIfNotAuth');
});
