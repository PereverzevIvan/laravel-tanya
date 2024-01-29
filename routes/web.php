<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'show_all_articles']);
Route::get('/one_article', [MainController::class, 'show_one_article']);
Route::get('/about_us', [MainController::class, 'show_about_us']);
Route::get('/contacts', [MainController::class, 'show_contacts']);

Route::get('/create_user', [AuthController::class, 'create']);
Route::post('/register', [AuthController::class, 'register']);